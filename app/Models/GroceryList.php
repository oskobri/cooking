<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroceryList extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToUser;

    protected function casts(): array
    {
        return [
            'recipe_updated_at' => 'datetime'
        ];
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)
            ->withPivot('done');
    }
}
