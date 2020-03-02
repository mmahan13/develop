<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'comun.proveedores';
	protected $fillable = ['codigoempresa','codigoproveedor','razonsocial','siglanacion','cifdni','email1','comentarios', 'iban','fechaalta'];
}