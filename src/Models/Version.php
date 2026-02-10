<?php

namespace Awcodes\Documental\Models;

use Awcodes\Documental\Database\Factories\VersionFactory;
use Awcodes\Documental\Enums\VersionStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property int $package_id
 * @property string $name
 * @property CarbonInterface $released_at
 * @property VersionStatus $status
 * @property array $navigation
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property Package $package
 * @property Collection<Page> $pages
 */
class Version extends Model
{
    use HasFactory;

    protected $table = 'documental_versions';

    protected static function newFactory(): VersionFactory
    {
        return new VersionFactory;
    }

    protected $fillable = [
        'package_id',
        'name',
        'released_at',
        'status',
        'navigation',
    ];

    protected $casts = [
        'id' => 'integer',
        'package_id' => 'integer',
        'released_at' => 'date',
        'status' => VersionStatus::class,
        'navigation' => 'array',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'version_id');
    }
}
