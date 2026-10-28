<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nom', 'telephone'])]
class Personne extends Model
{
    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class);
    }
}
