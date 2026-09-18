<?php

namespace Tests\Unit;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;

final class SolicitudesEvidenciaMigrationTest extends TestCase
{
    private Manager $database;
    private $previousFacadeApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->previousFacadeApplication = Facade::getFacadeApplication();
        Facade::clearResolvedInstances();
        $this->database = new Manager;
        $this->database->addConnection([
            'driver' => 'sqlite', 'database' => ':memory:', 'foreign_key_constraints' => true,
        ]);
        $container = $this->database->getContainer();
        $container->instance('db.schema', $this->database->getConnection()->getSchemaBuilder());
        Facade::setFacadeApplication($container);
    }

    protected function tearDown(): void
    {
        $this->database->getConnection()->disconnect();
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($this->previousFacadeApplication);
        parent::tearDown();
    }

    private function migration(string $name)
    {
        return require dirname(__DIR__, 2).'/database/migrations/tenant/'.$name.'.php';
    }

    public function test_retry_preserves_rows_and_finishes_deferred_foreign_key(): void
    {
        $migration = $this->migration('2025_01_17_153304_create_solicitudes_evidencia_table');
        $migration->up();
        $this->database->getConnection()->table('solicitudes_evidencia')->insert([
            'resguardo_id' => 7, 'motivo' => 'Conservar evidencia',
        ]);
        // Reproduce a table left behind by a failed migration without its FK.
        $migration->up();
        $this->assertSame('Conservar evidencia', $this->database->getConnection()->table('solicitudes_evidencia')->value('motivo'));
        $this->database->getConnection()->getSchemaBuilder()->create('resguardos', function ($table) {
            $table->id();
        });
        $this->database->getConnection()->table('resguardos')->insert(['id' => 7]);
        $foreignKey = $this->migration('2025_09_25_133702_add_resguardo_foreign_key_to_solicitudes_evidencia_table');
        $foreignKey->up();
        $foreignKey->up();
        $this->assertCount(1, $this->database->getConnection()->getSchemaBuilder()->getForeignKeys('solicitudes_evidencia'));
        $this->database->getConnection()->table('resguardos')->where('id', 7)->delete();
        $this->assertSame(0, $this->database->getConnection()->table('solicitudes_evidencia')->count());
        $foreignKey->down();
        $migration->down();
        $this->assertFalse($this->database->getConnection()->getSchemaBuilder()->hasTable('solicitudes_evidencia'));
    }

    public function test_fresh_table_can_be_created_before_resguardos(): void
    {
        $this->migration('2025_01_17_153304_create_solicitudes_evidencia_table')->up();
        $this->assertTrue($this->database->getConnection()->getSchemaBuilder()->hasTable('solicitudes_evidencia'));
        $this->assertFalse($this->database->getConnection()->getSchemaBuilder()->hasTable('resguardos'));
        $this->assertCount(0, $this->database->getConnection()->getSchemaBuilder()->getForeignKeys('solicitudes_evidencia'));
    }

    public function test_incomplete_existing_table_is_not_silently_accepted(): void
    {
        $this->database->getConnection()->getSchemaBuilder()->create('solicitudes_evidencia', function ($table) {
            $table->id();
        });
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('estructura incompleta');
        $this->migration('2025_01_17_153304_create_solicitudes_evidencia_table')->up();
    }
}
