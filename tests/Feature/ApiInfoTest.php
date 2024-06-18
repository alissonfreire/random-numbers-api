<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiInfoTest extends TestCase
{
    public function test_returns_all_info_values(): void
    {
        $response = $this->get('/api/info');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            "error_chance" => config('app.error_chance'),
            "max_page_size" => config('app.max_page_size'),
            "random_numbers_qty" => config('app.random_numbers_qty'),
        ]);
    }
}
