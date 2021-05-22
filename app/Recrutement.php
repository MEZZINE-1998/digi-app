<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recrutement extends Model
{
    protected $casts = [
        'id_condidats' => 'array'
    ];
}
