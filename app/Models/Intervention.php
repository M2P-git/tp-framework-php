<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['description', 'statut'])]
class Intervention extends Model
{
    // TODO (point 1) : une intervention concerne une seule machine (plusieurs à un).
    // Écrivez la méthode machine(), sur le modèle de Machine::personne().

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class);
    }
}
