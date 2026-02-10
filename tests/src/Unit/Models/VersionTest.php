<?php

use Awcodes\Documental\Models\Version;

test('to array', function () {
    $record = Version::factory()->create()->fresh();

    expect(array_keys($record->toArray()))
        ->toBe([
            'id',
            'package_id',
            'name',
            'released_at',
            'status',
            'created_at',
            'updated_at',
        ]);
});
