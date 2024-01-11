<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagine extends Model
{
    use HasFactory;
    protected $table = 'imagini';
    protected $guarded = [];

    public function path()
    {
        return "/imagini/{$this->id}";
    }
}
