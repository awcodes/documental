<?php

namespace Awcodes\Documental\Database\Factories;

use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'package_id' => Package::factory(),
            'version_id' => Version::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => $this->faker->randomElement(PublishStatus::class),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
