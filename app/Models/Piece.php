<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['nom'])]
class Piece extends Model
{
    public function interventions(): BelongsToMany
    {
        return $this->belongsToMany(Intervention::class);
    }
}
