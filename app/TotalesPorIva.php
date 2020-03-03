<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalesPorIva extends Model
{
    public $timestamps = false;
    protected $table = 'portal.totales_por_iva';
	protected $fillable = ['id_cabecera_factura', 'id_cliente', 'tipoiva', 'porcentaje', 'total_iva', 'total_importe'];
}

