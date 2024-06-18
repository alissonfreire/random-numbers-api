<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\RandomUtils;

class RandomUtilsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_generateNumbers_with_default_size(): void
    {
        $numbers = RandomUtils::generateNumbers();

        $this->assertIsArray($numbers);
        $this->assertCount(10, $numbers);

        foreach ($numbers as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_generateNumbers_with_custom_size(): void
    {
        $numbers = RandomUtils::generateNumbers(15);

        $this->assertIsArray($numbers);
        $this->assertCount(15, $numbers);

        foreach ($numbers as $number) {
            $this->assertIsFloat($number);
        }
    }

    public function test_randomChance_with_valid_percentage(): void
    {
        $result = RandomUtils::randomChance(100);

        $this->assertTrue($result);

        $result = RandomUtils::randomChance(0);

        $this->assertNotTrue($result);
    }

    public function test_getValidRandomChance_with_invalid_percentage(): void
    {
        $result = RandomUtils::getValidRandomChance(-1);

        $this->assertEquals(0, $result);

        $result = RandomUtils::getValidRandomChance(200);

        $this->assertEquals(100, $result);
    }
}
