<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplicatie extends Model
{
    use HasFactory;

    protected $table = 'aplicatii';
    protected $guarded = [];

    public function path()
    {
        return "/aplicatii/{$this->id}";
    }
}
