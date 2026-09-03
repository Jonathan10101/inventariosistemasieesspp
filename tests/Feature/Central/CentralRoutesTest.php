<?php

declare(strict_types=1);

namespace Tests\Feature\Central;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CentralRoutesTest extends TestCase
{
    /**
     * Verifica que exista al menos un dominio central configurado.
     */
    public function test_there_is_at_least_one_central_domain_configured(): void
    {
        $domains = config('tenancy.central_domains', []);

        $this->assertIsArray($domains);
        $this->assertNotEmpty(
            $domains,
            'No existen dominios centrales configurados en config/tenancy.php.'
        );
    }

    /**
     * Verifica que la página principal cargue correctamente
     * en todos los dominios centrales.
     */
    public function test_central_home_page_loads_successfully(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/')
            );

            $response
                ->assertOk()
                ->assertViewIs('central.home');
        }
    }

    /**
     * Verifica que la landing page cargue correctamente.
     */
    public function test_central_landing_page_loads_successfully(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/landing')
            );

            $response
                ->assertOk()
                ->assertViewIs('central.home2');
        }
    }

    /**
     * Verifica que el aviso de privacidad cargue correctamente.
     */
    public function test_privacy_page_loads_successfully(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/aviso-de-privacidad')
            );

            $response
                ->assertOk()
                ->assertViewIs('central.privacy');
        }
    }

    /**
     * Verifica que los términos del servicio carguen correctamente.
     */
    public function test_terms_page_loads_successfully(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/terminos-del-servicio')
            );

            $response
                ->assertOk()
                ->assertViewIs('central.terms');
        }
    }

    /**
     * Verifica que las condiciones comerciales carguen correctamente.
     */
    public function test_commercial_conditions_page_loads_successfully(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/condiciones-comerciales')
            );

            $response
                ->assertOk()
                ->assertViewIs('central.commercial');
        }
    }

    /**
     * Verifica el endpoint utilizado para comprobar
     * la conexión con INTEVI.
     */
    public function test_connection_endpoint_returns_no_content_and_no_cache_headers(): void
    {
        foreach ($this->centralDomains() as $domain) {
            $response = $this->get(
                $this->centralUrl($domain, '/conexion-intevi')
            );

            $response->assertNoContent();

            $cacheControl = (string) $response->headers->get(
                'Cache-Control'
            );

            $this->assertStringContainsString(
                'no-store',
                $cacheControl
            );

            $this->assertStringContainsString(
                'no-cache',
                $cacheControl
            );

            $this->assertStringContainsString(
                'must-revalidate',
                $cacheControl
            );

            $response->assertHeader('Pragma', 'no-cache');
            $response->assertHeader('Expires', '0');
        }
    }

    /**
     * Verifica los nombres principales de las rutas centrales.
     */
    public function test_primary_central_route_names_are_registered(): void
    {
        $routeNames = [
            'central.home',
            'central.home2',
            'privacidad',
            'terminos',
            'condiciones.comerciales',
            'central.connection',
        ];

        foreach ($routeNames as $routeName) {
            $this->assertTrue(
                Route::has($routeName),
                "La ruta [{$routeName}] no está registrada."
            );
        }
    }

    /**
     * Obtiene los dominios centrales configurados.
     *
     * @return array<int, string>
     */
    private function centralDomains(): array
    {
        $domains = config('tenancy.central_domains', []);

        $this->assertIsArray($domains);
        $this->assertNotEmpty(
            $domains,
            'No existen dominios centrales configurados.'
        );

        return array_values(
            array_filter(
                $domains,
                static fn ($domain): bool => is_string($domain)
                    && trim($domain) !== ''
            )
        );
    }

    /**
     * Construye una URL perteneciente al dominio central.
     */
    private function centralUrl(
        string $domain,
        string $path
    ): string {
        return sprintf(
            'http://%s/%s',
            trim($domain),
            ltrim($path, '/')
        );
    }
}