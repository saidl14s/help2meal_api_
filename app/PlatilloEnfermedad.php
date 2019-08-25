<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatilloEnfermedad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enfermedad_id', 'platillo_id'
    ];
}
