<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['serie', 'marque'])]
class Machine extends Model
{
    public function personne(): BelongsTo
    {
        return $this->belongsTo(Personne::class);
    }

    // TODO (point 1) : une machine a plusieurs interventions (un à plusieurs).
    // Écrivez la méthode interventions(), sur le modèle de Personne::machines().
}
