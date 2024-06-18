<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_page_numbers_when_page_is_not_filled(): void
    {
        $this->assertDatabaseCount('pages', 0);

        $pageNumber = 1;
        $pageNumberSize = config('app.random_numbers_qty');

        $response = $this->call('get', "/api/page/{$pageNumber}", ['no_error' => true]);

        $response->assertStatus(200);

        $response->assertJsonIsArray("numbers");
        $response->assertJsonCount($pageNumberSize, "numbers");

        $this->assertDatabaseCount('pages', 1);

        $numbers = Page::getPageNumbers($pageNumber);

        $returnedNumbers = $response->json("numbers");

        $this->assertEquals($returnedNumbers, $numbers);
    }

    public function test_returns_page_numbers_when_the_page_already_filled(): void
    {
        $pageNumber = 1;
        $numbers = [1, 2, 3];

        Page::factory(['page' => $pageNumber, 'numbers' => $numbers])->create();

        $response = $this->call('get', "/api/page/{$pageNumber}", ['no_error' => true]);

        $response->assertStatus(200);

        $response->assertJsonIsArray("numbers");
        $response->assertJsonCount(count($numbers), "numbers");

        $returnedNumbers = $response->json("numbers");

        $this->assertEquals($returnedNumbers, $numbers);
    }

    public function test_with_invalid_page_number(): void
    {
        $invalidValues = [-1, 0, 'test'];

        foreach ($invalidValues as $pageNumber) {
            $response = $this->call('get', "/api/page/{$pageNumber}", ['no_error' => true]);

            $response->assertStatus(422);

            $this->assertDatabaseCount('pages', 0);

            $response->assertJsonFragment([
                "message" => "Validation error",
                "error" => "pageNumber must be a positive integer number"
            ]);
        }
    }

    public function test_with_page_number_greater_than_max_page_size(): void
    {
        $max_page_size = config('app.max_page_size');
        $pageNumber = $max_page_size + 1;

        $response = $this->call('get', "/api/page/{$pageNumber}", ['no_error' => true]);

        $response->assertStatus(422);

        $this->assertDatabaseCount('pages', 0);

        $response->assertJsonFragment([
            "message" => "Validation error",
            "error" => "pageNumber must not be greater than {$max_page_size}"
        ]);
    }

    public function test_returns_error_with_one_hundred_chance(): void
    {
        $pageNumber = 1;

        $response = $this->call('get', "/api/page/{$pageNumber}", ['chance' => 100]);

        $response->assertStatus(400);

        $response->assertJsonFragment(["error" => "invalid return"]);
    }
}
