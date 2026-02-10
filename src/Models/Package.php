<?php

namespace Awcodes\Documental\Models;

use Awcodes\Documental\Database\Factories\PackageFactory;
use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Models\Scopes\PublishedScope;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property PublishStatus $status
 * @property string $description
 * @property string $github_url
 * @property int $stars
 * @property int $downloads
 * @property int $monthly_downloads
 * @property int $daily_downloads
 * @property string $latest_release
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property Collection<Version> $versions
 * @property Collection<Page> $pages
 */
#[ScopedBy([PublishedScope::class])]
class Package extends Model
{
    use HasFactory;

    protected $table = 'documental_packages';

    protected static function newFactory(): PackageFactory
    {
        return new PackageFactory;
    }

    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',
        'github_url',
        'stars',
        'downloads',
        'monthly_downloads',
        'daily_downloads',
        'latest_release',
    ];

    protected $casts = [
        'id' => 'integer',
        'stars' => 'integer',
        'downloads' => 'integer',
        'monthly_downloads' => 'integer',
        'daily_downloads' => 'integer',
        'status' => PublishStatus::class,
    ];

    public function versions(): HasMany
    {
        return $this->hasMany(Version::class, 'package_id')->orderBy('name', 'desc');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'package_id');
    }
}
