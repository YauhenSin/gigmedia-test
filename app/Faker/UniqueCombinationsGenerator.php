<?php

namespace App\Faker;

interface UniqueCombinationsGenerator
{
    public function run(array $words): array;
}
