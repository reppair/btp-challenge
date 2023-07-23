<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_one_user_weather(): void
    {
        $this->assertHasOne(User::factory(), 'weather', UserWeather::factory());
    }

    /** @test */
    public function user_weather_belongs_to_user(): void
    {
        $this->assertBelongsTo(UserWeather::factory(), 'user', User::factory());
    }

    protected function assertHasOne(Factory $parent, string $relation, Factory $child): void
    {
        $parent = $parent->has($child, $relation)->create();

        $this->assertInstanceOf(HasOne::class, $parent->$relation());

        $this->assertSame($parent->id, $parent->$relation->id);
    }

    protected function assertBelongsTo(Factory $child, string $relation, Factory $parent): void
    {
        $parent = $parent->create();

        $child = $child->for($parent, $relation)->create();

        $this->assertInstanceOf(BelongsTo::class, $child->$relation());

        $this->assertSame($parent->id, $child->$relation->id);
    }
}
