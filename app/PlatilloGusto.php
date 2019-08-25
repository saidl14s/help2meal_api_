<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatilloGusto extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gusto_id', 'platillo_id'
    ];
}
