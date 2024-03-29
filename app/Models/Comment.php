<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'commentable_id',
        'commentable_type'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function replies(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
