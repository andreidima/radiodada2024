<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'apps_facturi';
    protected $guarded = [];

    public function path()
    {
        return "/apps/facturi/{$this->id}";
    }

    /**
     * Get all of the actualizari for the Factura
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actualizari(): HasMany
    {
        return $this->hasMany(Actualizare::class, 'factura_id');
    }

    /**
     * Get all of the pontaje for the Factura
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function pontaje(): HasManyThrough
    {
        return $this->hasManyThrough(Pontaj::class, Actualizare::class);
    }
}
