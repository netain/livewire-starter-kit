<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_super',
    ];

    protected $casts = [
        'is_super' => 'boolean',
    ];

    /**
     * Get the users associated with the role.
     *
     * @return HasMany
     *
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
