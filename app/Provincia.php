<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'master.provincias';
	protected $fillable = ['provincia','provinciaid'];
}
