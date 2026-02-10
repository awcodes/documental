<?php

namespace Awcodes\Documental\Models;

use Awcodes\Documental\Database\Factories\PageFactory;
use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Models\Scopes\PublishedScope;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $version_id
 * @property string $title
 * @property string $slug
 * @property PublishStatus $status
 * @property array $content
 * @property int $parent_id
 * @property CarbonInterface $published_at
 * @property int $order_column
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property Version $version
 * @property Package $package
 */
#[ScopedBy([PublishedScope::class])]
class Page extends Model
{
    use HasFactory;

    protected $table = 'documental_pages';

    protected static function newFactory(): PageFactory
    {
        return new PageFactory;
    }

    protected $fillable = [
        'version_id',
        'title',
        'slug',
        'status',
        'content',
    ];

    protected $casts = [
        'id' => 'integer',
        'content' => 'array',
        'version_id' => 'integer',
        'status' => PublishStatus::class,
    ];

    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class, 'version_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
