<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculos extends Model
{
    
    protected $fillable = [
        'marca', 'modelo', 'ano','preco',
    ];
}
