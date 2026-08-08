<?php

declare(strict_types=1);

namespace Tests\Feature\Tenant;

use App\Http\Controllers\AreaDeAsignacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Etiqueta2Controller;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\ResguardanteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UbicacionFisicaController;
use App\Http\Middleware\EnsureSingleUserSession;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Tests\TestCase;

final class TenantRoutesTest extends TestCase
{
    /**
     * Acciones generadas por Route::resource().
     *
     * @var array<int, string>
     */
    private const RESOURCE_ACTIONS = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    /**
     * Comprueba que las rutas públicas del tenant estén registradas.
     */
    public function test_public_tenant_routes_are_registered(): void
    {
        $this->assertRouteExists('tenant.home');
        $this->assertRouteExists('tenant.connection');
    }

    /**
     * Comprueba que el dashboard esté registrado.
     */
    public function test_dashboard_route_is_registered(): void
    {
        $this->assertRouteExists('dashboard');
    }

    /**
     * Comprueba que todas las rutas resource estén registradas.
     */
    public function test_resource_routes_are_registered(): void
    {
        $resources = [
            'inventario',
            'marcas',
            'resguardante',
            'puestos',
            'ubicacionfisica',
            'roles',
        ];

        foreach ($resources as $resource) {
            foreach (self::RESOURCE_ACTIONS as $action) {
                $this->assertRouteExists(
                    "{$resource}.{$action}"
                );
            }
        }
    }

    /**
     * Comprueba que las rutas particulares estén registradas.
     */
    public function test_specific_tenant_routes_are_registered(): void
    {
        $routeNames = [
            'areadeasignacion.index',
            'areadeasignacion.store',
            'etiquetas.show',
            'etiquetas2.show',
        ];

        foreach ($routeNames as $routeName) {
            $this->assertRouteExists($routeName);
        }
    }

    /**
     * Comprueba que la ruta de conexión sea pública.
     */
    public function test_connection_route_is_public(): void
    {
        $middleware = $this->middlewareFor(
            'tenant.connection'
        );

        $this->assertContains(
            'web',
            $middleware
        );

        $this->assertContains(
            InitializeTenancyByDomain::class,
            $middleware
        );

        $this->assertContains(
            PreventAccessFromCentralDomains::class,
            $middleware
        );

        $this->assertNotContains(
            'auth:sanctum',
            $middleware
        );

        $this->assertNotContains(
            'verified',
            $middleware
        );

        $this->assertNotContains(
            EnsureSingleUserSession::class,
            $middleware
        );
    }

    /**
     * Comprueba que la página inicial del tenant sea pública.
     */
    public function test_tenant_home_route_is_public(): void
    {
        $middleware = $this->middlewareFor(
            'tenant.home'
        );

        $this->assertContains(
            InitializeTenancyByDomain::class,
            $middleware
        );

        $this->assertContains(
            PreventAccessFromCentralDomains::class,
            $middleware
        );

        $this->assertNotContains(
            'auth:sanctum',
            $middleware
        );

        $this->assertNotContains(
            'verified',
            $middleware
        );

        $this->assertNotContains(
            EnsureSingleUserSession::class,
            $middleware
        );
    }

    /**
     * Comprueba que las rutas privadas tengan los middleware
     * generales de seguridad.
     */
    public function test_protected_routes_use_security_middlewares(): void
    {
        $protectedRoutes = [
            'dashboard',
            'inventario.index',
            'marcas.index',
            'resguardante.index',
            'puestos.index',
            'ubicacionfisica.index',
            'areadeasignacion.index',
            'areadeasignacion.store',
            'roles.index',
            'etiquetas.show',
            'etiquetas2.show',
        ];

        foreach ($protectedRoutes as $routeName) {
            $middleware = $this->middlewareFor(
                $routeName
            );

            $this->assertContains(
                InitializeTenancyByDomain::class,
                $middleware,
                "La ruta [{$routeName}] no inicializa tenancy."
            );

            $this->assertContains(
                PreventAccessFromCentralDomains::class,
                $middleware,
                "La ruta [{$routeName}] permite dominios centrales."
            );

            $this->assertContains(
                'auth:sanctum',
                $middleware,
                "La ruta [{$routeName}] no requiere autenticación."
            );

            $this->assertContains(
                'verified',
                $middleware,
                "La ruta [{$routeName}] no requiere correo verificado."
            );

            $this->assertContains(
                EnsureSingleUserSession::class,
                $middleware,
                "La ruta [{$routeName}] no valida la sesión única."
            );
        }
    }

    /**
     * Comprueba el permiso general del inventario.
     */
    public function test_inventory_routes_require_inventory_permission(): void
    {
        foreach (self::RESOURCE_ACTIONS as $action) {
            $this->assertRouteHasMiddleware(
                "inventario.{$action}",
                'can:inventario.index'
            );
        }
    }

    /**
     * Comprueba el permiso general de marcas.
     */
    public function test_brand_routes_require_brand_permission(): void
    {
        foreach (self::RESOURCE_ACTIONS as $action) {
            $this->assertRouteHasMiddleware(
                "marcas.{$action}",
                'can:marcas.create'
            );
        }
    }

    /**
     * Comprueba el permiso general de resguardantes.
     */
    public function test_resguardante_routes_require_permission(): void
    {
        foreach (self::RESOURCE_ACTIONS as $action) {
            $this->assertRouteHasMiddleware(
                "resguardante.{$action}",
                'can:resguardante.create'
            );
        }
    }

    /**
     * Comprueba el permiso general de puestos.
     */
    public function test_job_position_routes_require_permission(): void
    {
        foreach (self::RESOURCE_ACTIONS as $action) {
            $this->assertRouteHasMiddleware(
                "puestos.{$action}",
                'can:puestos.create'
            );
        }
    }

    /**
     * Comprueba el permiso de ubicaciones físicas.
     */
    public function test_physical_location_routes_require_permission(): void
    {
        foreach (self::RESOURCE_ACTIONS as $action) {
            $this->assertRouteHasMiddleware(
                "ubicacionfisica.{$action}",
                'can:ubicacionfisica.create'
            );
        }
    }

    /**
     * Comprueba que cada acción de áreas de asignación
     * utilice únicamente el permiso correspondiente.
     */
    public function test_area_routes_use_correct_permissions(): void
    {
        $indexMiddleware = $this->middlewareFor(
            'areadeasignacion.index'
        );

        $storeMiddleware = $this->middlewareFor(
            'areadeasignacion.store'
        );

        $this->assertContains(
            'can:areadeasignacion.index',
            $indexMiddleware
        );

        $this->assertNotContains(
            'can:areadeasignacion.create',
            $indexMiddleware,
            'El listado de áreas no debería requerir permiso de creación.'
        );

        $this->assertContains(
            'can:areadeasignacion.create',
            $storeMiddleware
        );
    }

    /**
     * Comprueba los permisos de las etiquetas.
     */
    public function test_label_routes_require_inventory_permission(): void
    {
        $this->assertRouteHasMiddleware(
            'etiquetas.show',
            'can:inventario.index'
        );

        $this->assertRouteHasMiddleware(
            'etiquetas2.show',
            'can:inventario.index'
        );
    }

    /**
     * Comprueba URI y método HTTP de las rutas públicas.
     */
    public function test_public_routes_have_correct_uris_and_methods(): void
    {
        $this->assertRouteDefinition(
            'tenant.home',
            '/',
            'GET'
        );

        $this->assertRouteDefinition(
            'tenant.connection',
            'conexion-intevi',
            'GET'
        );
    }

    /**
     * Comprueba las rutas de áreas de asignación.
     */
    public function test_area_routes_have_correct_uris_and_methods(): void
    {
        $this->assertRouteDefinition(
            'areadeasignacion.index',
            'areadeasignacion',
            'GET'
        );

        $this->assertRouteDefinition(
            'areadeasignacion.store',
            'areadeasignacion',
            'POST'
        );
    }

    /**
     * Comprueba las rutas de etiquetas.
     */
    public function test_label_routes_have_correct_uris_and_methods(): void
    {
        $this->assertRouteDefinition(
            'etiquetas.show',
            'etiqueta/{codigo}',
            'GET'
        );

        $this->assertRouteDefinition(
            'etiquetas2.show',
            'etiqueta2/{codigo}',
            'GET'
        );
    }

    /**
     * Comprueba los controladores de las rutas principales.
     */
    public function test_routes_point_to_correct_controllers(): void
    {
        $routes = [
            'dashboard' => DashboardController::class . '@index',
            'inventario.index' => InventarioController::class . '@index',
            'marcas.index' => MarcaController::class . '@index',
            'resguardante.index' => ResguardanteController::class . '@index',
            'puestos.index' => PuestoController::class . '@index',
            'ubicacionfisica.index' => UbicacionFisicaController::class . '@index',
            'areadeasignacion.index' => AreaDeAsignacionController::class . '@index',
            'areadeasignacion.store' => AreaDeAsignacionController::class . '@store',
            'roles.index' => RolController::class . '@index',
            'etiquetas.show' => EtiquetaController::class . '@show',
            'etiquetas2.show' => Etiqueta2Controller::class . '@show',
        ];

        foreach ($routes as $routeName => $controllerAction) {
            $route = $this->routeByName($routeName);

            $this->assertSame(
                $controllerAction,
                $route->getActionName(),
                "La ruta [{$routeName}] apunta a un controlador incorrecto."
            );
        }
    }

    /**
     * Comprueba que una ruta exista.
     */
    private function assertRouteExists(string $routeName): void
    {
        $this->assertTrue(
            Route::has($routeName),
            "La ruta [{$routeName}] no está registrada."
        );
    }

    /**
     * Comprueba que una ruta tenga un middleware.
     */
    private function assertRouteHasMiddleware(
        string $routeName,
        string $expectedMiddleware
    ): void {
        $middleware = $this->middlewareFor(
            $routeName
        );

        $this->assertContains(
            $expectedMiddleware,
            $middleware,
            "La ruta [{$routeName}] no contiene el middleware [{$expectedMiddleware}]."
        );
    }

    /**
     * Comprueba URI y método HTTP de una ruta.
     */
    private function assertRouteDefinition(
        string $routeName,
        string $expectedUri,
        string $expectedMethod
    ): void {
        $route = $this->routeByName(
            $routeName
        );

        $this->assertSame(
            $expectedUri,
            $route->uri(),
            "La URI de [{$routeName}] es incorrecta."
        );

        $this->assertContains(
            $expectedMethod,
            $route->methods(),
            "La ruta [{$routeName}] no acepta el método [{$expectedMethod}]."
        );
    }

    /**
     * Obtiene una ruta por su nombre.
     */
    private function routeByName(string $routeName): LaravelRoute
    {
        $route = Route::getRoutes()->getByName(
            $routeName
        );

        $this->assertNotNull(
            $route,
            "La ruta [{$routeName}] no está registrada."
        );

        return $route;
    }

    /**
     * Obtiene todos los middleware asociados a una ruta.
     *
     * @return array<int, string>
     */
    private function middlewareFor(string $routeName): array
    {
        return $this->routeByName(
            $routeName
        )->gatherMiddleware();
    }
}