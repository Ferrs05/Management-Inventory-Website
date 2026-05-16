<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    public const CONDITION_GOOD = 'good';
    public const CONDITION_MINOR_DAMAGE = 'minor_damage';
    public const CONDITION_DAMAGED = 'damaged';
    public const CONDITION_LOST = 'lost';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'quantity_total',
        'quantity_available',
        'condition',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'quantity_total' => 'integer',
            'quantity_available' => 'integer',
        ];
    }

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeAvailable($query)
    {
        return $query
            ->where('is_active', true)
            ->where('quantity_available', '>', 0)
            ->whereNotIn('condition', [self::CONDITION_DAMAGED, self::CONDITION_LOST]);
    }

    public function isAvailable(int $quantity = 1): bool
    {
        return $this->is_active
            && $this->quantity_available >= $quantity
            && ! in_array($this->condition, [self::CONDITION_DAMAGED, self::CONDITION_LOST], true);
    }
}
