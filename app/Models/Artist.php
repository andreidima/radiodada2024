<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    
    protected $table = 'artisti';
    protected $guarded = [];

    public function path()
    {
        return "/artisti/{$this->id}";
    }

    public function imagine()
    {
        return $this->hasOne('App\Models\Imagine', 'referinta_id')->where('referinta_categorie', 'artisti');
    }
}
