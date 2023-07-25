<?php

namespace Tests\Unit;

use App\Services\Weather\Weather;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class WeatherTest extends TestCase
{
    protected ReflectionClass $weather;

    protected function setUp(): void
    {
        parent::setUp();

        $this->weather = new ReflectionClass(Weather::class);
    }

    /** @test */
    public function it_is_an_abstract_class(): void
    {
        $this->assertTrue($this->weather->isAbstract());
    }
}
