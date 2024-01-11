<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piesa extends Model
{
    use HasFactory;
    
    protected $table = 'piese';
    protected $guarded = [];

    public function path()
    {
        return "/piese/{$this->id}";
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\Artist');
    }
}
