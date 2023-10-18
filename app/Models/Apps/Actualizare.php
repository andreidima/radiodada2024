<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
