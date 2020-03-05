<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabeceraFactura extends Model
{
    public $timestamps = false;
    protected $table = 'portal.cabecera_factura';
    protected $fillable = ['id', 'id_user', 'id_cliente', 'seriefactura', 'numerofactura', 'fecha_factura', 'importebruto', 'pordescuento','importedescuento', 'baseimponible', 'totaliva', 'totalfactura', 'observacionesfactura'];
}
