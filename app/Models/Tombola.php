<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tombola extends Model
{
    use HasFactory;

    protected $table = 'tombole';
    protected $guarded = [];

    public function path()
    {
        return "/tombole/{$this->id}";
    }
}
