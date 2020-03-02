<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = false;
    protected $table = 'portal.clientes';
	protected $fillable = ['id_user','nombre', 'apellidos', 'email', 'telefono', 'dni', 'direccion', 'ciudad', 'pais'];
}

