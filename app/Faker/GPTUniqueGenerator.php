<?php

namespace App\Faker;

class GPTUniqueGenerator implements UniqueCombinationsGenerator
{
    /**
     * @param string[] $words
     *
     * @return string[]
     */
    public function run(array $words): array
    {
        $result = [];
        $this->combine('', $words, $result);
        return array_unique($result);
    }

    /**
     * @param string[] $words
     * @param string[] $result
     */
    private function combine(string $prefix, array $words, array &$result): void
    {
        for ($i = 0; $i < count($words); $i++) {
            $newPrefix = trim($prefix . ' ' . $words[$i]);

            $result[] = $newPrefix;

            $remainingWords = array_slice($words, $i + 1);
            $this->combine($newPrefix, $remainingWords, $result);
        }
    }
}
