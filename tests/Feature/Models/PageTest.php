<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Page;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_getPageNumbers_when_database_is_empty(): void
    {
        $this->assertDatabaseCount('pages', 0);

        $page = 1;
        $numbers = Page::getPageNumbers($page);

        $this->assertDatabaseCount('pages', 1);

        $pageNumberSize = config('app.random_numbers_qty');

        $this->assertCount($pageNumberSize, $numbers);

        foreach ($numbers as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_getPageNumbers_when_the_page_already_filled(): void
    {
        $page = 1;
        $numbers = [1, 2, 3];

        Page::factory(['page' => $page, 'numbers' => $numbers])->create();

        $returnedNumbers = Page::getPageNumbers($page);

        $this->assertDatabaseCount('pages', 1);

        $this->assertEquals($returnedNumbers, $numbers);
    }
}
