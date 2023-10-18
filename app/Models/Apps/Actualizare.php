<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualizare extends Model
{
    use HasFactory;

    protected $table = 'apps_actualizari';
    protected $guarded = [];

    public function path()
    {
        return "/apps/actualizari/{$this->id}";
    }
}
