<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'email',
        'link',
        'tags',
        'approved'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeFilters($query, $filters)
    {
        if($filters['search'] ?? false) {
            $query->whereAny(['title', 'desc'], 'like', '%' . request('search') . '%');
        }

        if($filters['user_id'] ?? false) {
            $query->where('user_id', request('user_id'));
        }

        if($filters['tag'] ?? false) {
            $query->where('tags', 'LIKE', '%'.request('tag').'%');
        }
    }
}
