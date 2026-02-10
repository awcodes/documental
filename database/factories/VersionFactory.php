<?php

namespace Awcodes\Documental\Database\Factories;

use Awcodes\Documental\Enums\VersionStatus;
use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
{
    protected $model = Version::class;

    public function definition(): array
    {
        return [
            'package_id' => Package::factory(),
            'name' => $this->faker->randomDigit() . '.x',
            'released_at' => $this->faker->date(),
            'status' => $this->faker->randomElement(VersionStatus::class),
            'navigation' => [],
        ];
    }
}
