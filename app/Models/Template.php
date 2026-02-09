<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $guarded = []; //guarded es cuando quieres que todos los campos sean asignables

    protected $casts = [
        'tags' => 'array'
    ];
}
