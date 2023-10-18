<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplicatie extends Model
{
    use HasFactory;

    protected $table = 'apps_aplicatii';
    protected $guarded = [];

    public function path()
    {
        return "/apps/aplicatii/{$this->id}";
    }
}
