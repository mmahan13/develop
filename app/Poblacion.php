<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poblacion extends Model
{
    protected $table = 'master.poblaciones';
	protected $fillable = ['poblacionid','provinciaid','poblacion', 'ineid', 'lat', 'lon', 'codigoautonomia'];
}


