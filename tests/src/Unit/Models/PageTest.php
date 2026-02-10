<?php

use Awcodes\Documental\Models\Page;

test('to array', function () {
    $record = Page::factory()->create()->fresh();

    expect(array_keys($record->toArray()))
        ->toBe([
            'id',
            'version_id',
            'title',
            'slug',
            'status',
            'content',
            'parent_id',
            'published_at',
            'order_column',
            'created_at',
            'updated_at',
        ]);
});
