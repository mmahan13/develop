<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposIvas extends Model
{
    protected $table = 'portal.tipos_iva';
	protected $fillable = ['id','poriva','tipiva'];
}
