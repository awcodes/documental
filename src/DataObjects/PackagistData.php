<?php

namespace Awcodes\Documental\DataObjects;

use Illuminate\Support\Collection;

readonly class PackagistData
{
    public function __construct(
        public string $description,
        public int | string | null $version,
        public int $stars,
        public int $total_downloads,
        public int $monthly_downloads,
        public int $daily_downloads,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function fromArray(array $data): self
    {
        return new self(
            description: $data['description'],
            version: (new Collection($data['versions']))
                ->filter(fn (array $version, string $key): bool => ! str_contains($key, 'dev'))->keys()->first(),
            stars: $data['github_stars'],
            total_downloads: $data['downloads']['total'],
            monthly_downloads: $data['downloads']['monthly'],
            daily_downloads: $data['downloads']['daily'],
        );
    }
}
