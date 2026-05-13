<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $table = 'school_books';

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'edition',
        'subject',
        'total_copies',
        'available_copies',
        'location',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'total_copies' => 'integer',
            'available_copies' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->available_copies > 0;
    }
}
