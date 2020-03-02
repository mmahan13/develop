<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    public $timestamps = false;
    protected $table = 'portal.contador';
	protected $fillable = ['id', 'contador'];
}

