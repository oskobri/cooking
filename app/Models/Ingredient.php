<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)
            ->withPivot(['quantity', 'unit']);
    }
}
