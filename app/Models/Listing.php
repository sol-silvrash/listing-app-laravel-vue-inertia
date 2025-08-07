<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'tags',
        'email',
        'link',
        'image',
        'approved',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        //** --> search filter <-- */
        if (!empty($filters['search'])) {
            $query->whereAny(
                [
                    'title',
                    'desc'
                ],
                'like',
                '%' . $filters['search'] . '%'
            );
        }

        //** --> User ID Filter <-- */
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        //** --> Tag Filter <-- */
        if (!empty($filters['tag'])) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }
        //** --> Disapproved Filter <-- */
        if (!empty($filters['disapproved'])) {
            $query->where('approved', false);
        }
    }

    public function scopeWithActiveUser(Builder $query)
    {
        return $query->whereHas(
            'user',
            function (Builder $q) {
                $q->where('role', '!=', 'suspended');
            }
        )->with('user');
    }
}
