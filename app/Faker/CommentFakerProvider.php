<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Collection;

class CommentFakerProvider extends Base
{
    /** @var ?Collection<string> */
    private ?Collection $fakeComments = null;

    public function comment(): string
    {
        return $this->getFakeComments()->shift();
    }

    public function commentsCount(): int
    {
        return $this->getFakeComments()->count();
    }

    /**
     * @return Collection<string>
     */
    private function getFakeComments(): Collection
    {
        if ( ! $this->fakeComments) {
            $this->fakeComments = $this->generateFakeComments();
        }

        return $this->fakeComments;
    }

    /**
     * @return Collection<string>
     */
    private function generateFakeComments(): Collection
    {
        return collect(
            $this->getUniqueGenerator()->run($this->getWords())
        );
    }

    private function getUniqueGenerator(): UniqueCombinationsGenerator
    {
        return app(UniqueCombinationsGenerator::class);
    }

    private function getWords(): array
    {
        return explode(',', strtolower(config('gigmedia.comment_faker_words', '')));
    }
}
