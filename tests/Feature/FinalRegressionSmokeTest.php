<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FinalRegressionSmokeTest extends TestCase
{
    public function test_all_controller_routes_point_to_existing_methods(): void
    {
        $failures = [];

        foreach (Route::getRoutes() as $route) {
            $action = $route->getActionName();

            if (!str_contains($action, '@')) {
                continue;
            }

            [$controller, $method] = explode('@', $action, 2);

            if (!class_exists($controller)) {
                $failures[] = "Missing controller {$controller} for {$route->uri()}";
                continue;
            }

            if (!method_exists($controller, $method)) {
                $failures[] = "Missing method {$controller}@{$method} for {$route->uri()}";
            }
        }

        $this->assertSame(
            [],
            $failures,
            implode(PHP_EOL, $failures)
        );
    }

    public function test_legacy_public_pages_no_longer_point_to_missing_views(): void
    {
        $this->get(route('tentang.visi-misi'))
            ->assertOk();

        $this->get(route('tentang.kontak'))
            ->assertOk();

        $this->get(route('portofolio.katalog'))
            ->assertOk();
    }

    public function test_haki_uses_server_rendered_whatsapp_number(): void
    {
        $response = $this->get(route('haki.index'));

        $response->assertOk();

        $response->assertSee(
            'https://wa.me/' . config('bacadulu.call_center_wa'),
            false
        );

        $response->assertDontSee(
            "const waNumber = config('bacadulu.call_center_wa')",
            false
        );
    }
}
