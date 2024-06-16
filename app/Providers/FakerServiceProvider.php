<?php

namespace App\Providers;

use App\Faker\CommentFakerProvider;
use App\Faker\GPTUniqueGenerator;
use App\Faker\UniqueCombinationsGenerator;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new CommentFakerProvider($faker));
            return $faker;
        });

        $this->app->singleton(UniqueCombinationsGenerator::class, fn () => new GPTUniqueGenerator());
    }

    public function boot(): void
    {
        //
    }
}
