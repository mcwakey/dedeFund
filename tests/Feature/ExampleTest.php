<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/fr');

        $response->assertStatus(200);
    }

    public function test_legacy_index_php_urls_redirect_to_clean_paths(): void
    {
        $this->get('/index.php/fr/about')
            ->assertRedirect('/fr/about');
    }
}
