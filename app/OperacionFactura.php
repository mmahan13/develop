<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperacionFactura extends Model
{
    protected $table = 'operaciones_factura';
    protected $fillable = [
        'codigo',
        'descripcion',
        'cantidad',
        'descuento',
        'importe',
        'iva_concepto',
        'iva_concepto_showname',
        'iva_concepto_factor',
        'iva_concepto_factor_recargo',
        'total_operacion',
        'factura_emitida_id'
    ];
}
