<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actualizare extends Model
{
    use HasFactory;

    protected $table = 'apps_actualizari';
    protected $guarded = [];

    public function path()
    {
        return "/apps/actualizari/{$this->id}";
    }

    /**
     * Get the aplicatie that owns the Actualizare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aplicatie(): BelongsTo
    {
        return $this->belongsTo(Aplicatie::class, 'aplicatie_id');
    }

    /**
     * Get all of the pontaje for the Actualizare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pontaje(): HasMany
    {
        return $this->hasMany(Pontaj::class, 'actualizare_id');
    }

    /**
     * Get the factura that owns the Actualizare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
