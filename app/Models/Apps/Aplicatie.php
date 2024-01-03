<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Aplicatie extends Model
{
    use HasFactory;

    protected $table = 'apps_aplicatii';
    protected $guarded = [];

    public function path()
    {
        return "/apps/aplicatii/{$this->id}";
    }

    /**
     * Get all of the actualizari for the Aplicatie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actualizari(): HasMany
    {
        return $this->hasMany(Actualizare::class, 'aplicatie_id');
    }

    /**
     * Get all of the pontaje for the Aplicatie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function pontaje(): HasManyThrough
    {
        return $this->hasManyThrough(Pontaj::class, Actualizare::class);
    }
}
