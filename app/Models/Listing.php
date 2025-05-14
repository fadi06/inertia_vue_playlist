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
}
