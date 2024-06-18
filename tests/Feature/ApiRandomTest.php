<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiRandomTest extends TestCase
{

    public function test_successfully_returns_random_numbers(): void
    {
        $response = $this->get('/api/random');

        $response->assertStatus(200);

        $response->assertJsonIsArray("numbers");
        $response->assertJsonCount(10, "numbers");

        foreach ($response->json("numbers") as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_successfully_returns_random_numbers_with_array_size(): void
    {
        $response = $this->call('get', '/api/random', ['qty' => 15]);

        $response->assertStatus(200);

        $response->assertJsonIsArray("numbers");
        $response->assertJsonCount(15, "numbers");

        foreach ($response->json("numbers") as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_maybe_error_returns_random_numbers_with_zero_chance(): void
    {
        $response = $this->call('get', '/api/maybe-error-random', ['chance' => 0]);

        $response->assertStatus(200);

        $response->assertJsonIsArray("numbers");
        $response->assertJsonCount(10, "numbers");

        foreach ($response->json("numbers") as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_maybe_error_returns_random_numbers_with_one_hundred_chance(): void
    {
        $response = $this->call('get', '/api/maybe-error-random', ['chance' => 100]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["error" => "invalid return"]);
    }
}
