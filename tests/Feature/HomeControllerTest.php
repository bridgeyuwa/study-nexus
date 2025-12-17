<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_home_page_returns_correct_view()
    {
        $response = $this->get('/');

        $response->assertViewIs('home');
    }

    public function test_home_page_has_required_variables()
    {
        $response = $this->get('/');

        $response->assertViewHasAll([
            'institutions',
            'programs',
            'categoryClasses',
            'levels',
            'SEOData',
        ]);
    }
}
