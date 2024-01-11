<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propunere extends Model
{
    use HasFactory;
    
    protected $table = 'propuneri';
    protected $guarded = [];

    public function path()
    {
        return "/propuneri/{$this->id}";
    }
}
