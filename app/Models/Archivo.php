<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
    ];

    public function libro(){
        return $this->morphTo();
    }

    public function user(){
        return $this->morphTo();
    }

    public function evento(){
        return $this->morphTo();
    }

}
