<?php

namespace Awcodes\Documental\Models\Scopes;

use Awcodes\Documental\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PublishedScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', PublishStatus::Published);
    }
}
