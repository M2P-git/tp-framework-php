<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['description', 'statut'])]
class Intervention extends Model
{
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class);
    }
}
