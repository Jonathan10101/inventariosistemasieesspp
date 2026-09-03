<?php

namespace Tests\Feature\Central;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /**
     * Comprueba que la página principal de INTEVI carga correctamente.
     */
    public function test_landing_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}