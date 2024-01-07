<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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
     * Get all of the pontaje for the Actualizare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pontajeAzi(): HasMany
    {
        return $this->hasMany(Pontaj::class, 'actualizare_id')->whereDate('inceput', Carbon::now()->toDateString());
    }

    /**
     * Get all of the pontaje for the Actualizare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pontajeAziDeschise(): HasMany
    {
        return $this->hasMany(Pontaj::class, 'actualizare_id')->whereDate('inceput', Carbon::now()->toDateString())->whereNull('sfarsit');
    }

    private function pontajeDurataCalculare($pontaje)
    {
        if ($pontaje->count()){
            $durata = Carbon::today();
        } else {
            $durata = null;
        }

        foreach ($pontaje as $pontaj) {
            // Daca vreunul din pontaje nu este inchis in acceasi zi, se transmite inapoi un mesaj de eroare
            if (Carbon::parse($pontaj->inceput)->toDateString() !== Carbon::parse($pontaj->sfarsit)->toDateString()){
                return (Carbon::today()->subMinutes(1));
            }
            $durata->addSeconds(Carbon::parse($pontaj->sfarsit)->diffInSeconds(Carbon::parse($pontaj->inceput)));
        }
        return ($durata);
    }

    public function pontajeAziDurata(){
        return ($this->pontajeDurataCalculare($this->pontajeAzi));
    }

    public function pontajeDurata(){
        return ($this->pontajeDurataCalculare($this->pontaje));
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
