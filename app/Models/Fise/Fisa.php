<?php

namespace App\Models\Fise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Fisa extends Model
{
    use HasFactory;

    protected $table = 'fise';
    protected $guarded = [];

    public function path()
    {
        return "/fise/fise/{$this->id}";
    }

    /**
     * Get all of the actualizari for the Fisa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sani(): HasMany
    {
        return $this->hasMany(San::class, 'fisa_id');
    }
}
