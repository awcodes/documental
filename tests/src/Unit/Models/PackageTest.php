<?php

use Awcodes\Documental\Models\Package;

test('to array', function () {
    $record = Package::factory()->create()->fresh();

    expect(array_keys($record->toArray()))
        ->toBe([
            'id',
            'name',
            'slug',
            'status',
            'description',
            'github_url',
            'stars',
            'downloads',
            'latest_release',
            'created_at',
            'updated_at',
        ]);
});
