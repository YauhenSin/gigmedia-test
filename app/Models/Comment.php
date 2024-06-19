<?php

namespace App\Models;

use App\Http\Filters\CommentFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Post $post
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'content',
        'abbreviation',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeFilter(Builder $query, CommentFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
