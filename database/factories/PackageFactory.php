<?php

namespace Awcodes\Documental\Database\Factories;

use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        $name = Str::title($this->faker->words(mt_rand(1, 3), true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'status' => $this->faker->randomElement(PublishStatus::class),
            'description' => $this->faker->text(),
            'github_url' => $this->faker->word(),
            'stars' => $this->faker->randomNumber(4),
            'downloads' => $this->faker->randomNumber(6),
            'monthly_downloads' => $this->faker->randomNumber(4),
            'daily_downloads' => $this->faker->randomNumber(2),
            'latest_release' => 'dev',
        ];
    }
}
