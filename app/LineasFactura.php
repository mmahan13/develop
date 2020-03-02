<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineasFactura extends Model
{
    public $timestamps = false;
    protected $table = 'portal.lineas_factura';
    protected $fillable = ['id_cabecera_factura', 'id_cliente', 'id_articulo', 'codigoarticulo', 'descripcionarticulo', 'descripcionlinea', 'cantidad', 'precioventa', 'descuento', 'poriva', 'tipoiva', 'liquidolinea', 'brutolinea', 'descuentolinea', 'valorlinea'];
}
