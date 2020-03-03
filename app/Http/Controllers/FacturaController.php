<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
//use App\libraries\PdfInvoice;
use Carbon\Carbon;
use App\Traits\PdfTrait;


use App\CabeceraFactura;
use App\LineasFactura;
use App\Contador;
use App\TotalesPorIva;

class FacturaController extends Controller
{
	use PdfTrait;

    public function numeroFactura(Request $request)
    {
        try{
            $contador = Contador::first();
            if(isset($contador['contador'])){
                $contador->contador = $contador['contador'] +1;
                $contador->save();
                return $data = [ substr(date("Y"), -2),
                                $contador['contador']
                            ];
            }
        }catch(Exception $e){
                return response('Error',500);
        }     
    }




    public function listaFacturas(Request $request)
    {	
    	try{	

	   		 return DB::select('exec ventas.listado_facturas ?',[3]);
		
		}catch(Exception $e){
          return response('Error',500);
        }   
	}

    public function lineasFacturas(Request $request)
    {   
        try{    
             return DB::select('exec ventas.listado_lineas_factura ?', [$request['idfactura']]);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    

    
    public function guardarFactura(Request $request)
    {
        try{
  
            if(!isset($request['numerofactura']))
            {
                $contador = Contador::first();
                if(isset($contador['contador'])){
                    $contador->contador = $contador['contador'] +1;
                    $contador->save();
                }
            }

            $cabecera_factura = new CabeceraFactura;
            $cabecera_factura->id_user = auth()->user()->id;
            $cabecera_factura->id_cliente = $request['idcliente'];
            $cabecera_factura->seriefactura  = (isset($request['seriefactura'])) ? $request['seriefactura']:substr(date("Y"), -2);
            $cabecera_factura->numerofactura = (isset($request['numerofactura'])) ? $request['numerofactura']:$contador['contador'];
            $cabecera_factura->fecha_factura = (isset($request['fecha'])) ? $request['fecha']: date('Ymd');
            $cabecera_factura->importebruto  = (isset($request['importebruto'])) ? $request['importebruto']:0;
            $cabecera_factura->pordescuento  = (isset($request['pordescuento'])) ? $request['pordescuento']:0;
            $cabecera_factura->importedescuento  = (isset($request['descuentototalfactura'])) ? $request['descuentototalfactura']:0;
            $cabecera_factura->baseimponible = (isset($request['baseimponible'])) ? $request['baseimponible']:0;
            $cabecera_factura->totaliva = (isset($request['totaliva'])) ? $request['totaliva']:0;
            $cabecera_factura->totalfactura = (isset($request['totalfactura'])) ? $request['totalfactura']:0;
            $cabecera_factura->observacionesfactura  = (isset($request['observacionesfactura'])) ? $request['observacionesfactura']:'';
            $cabecera_factura->save();
           

            foreach ($request['articulos'] as $articulo) {
                $descuento = ($articulo['descuento'] == 0) ? 0: $articulo['descuento'];

                    $lineas_factura = new LineasFactura;
                    $lineas_factura->id_cabecera_factura  = $cabecera_factura->id;
                    $lineas_factura->id_cliente  = $request['idcliente'];
                    $lineas_factura->id_articulo  = (isset($articulo['idarticulo'])) ? $articulo['idarticulo']:0;
                    $lineas_factura->codigoarticulo  = (isset($articulo['codigoarticulo'])) ? $articulo['codigoarticulo']:'';
                    $lineas_factura->descripcionarticulo  = (isset($articulo['descripcionarticulo'])) ? $articulo['descripcionarticulo']:'';
                    $lineas_factura->descripcionlinea  = (isset($articulo['descripcionlinea'])) ? $articulo['descripcionlinea'] : '';
                    $lineas_factura->cantidad  = (isset($articulo['cantidad'])) ? $articulo['cantidad']:0;
                    $lineas_factura->precioventa  = (isset($articulo['precioventa'])) ?$articulo['precioventa']:0; 
                    $lineas_factura->descuento  = (isset($descuento)) ? $descuento:0;
                    $lineas_factura->poriva  = (isset($articulo['porcentaje'])) ? $articulo['porcentaje']:0;
                    $lineas_factura->tipoiva  = (isset($articulo['tipoiva'])) ? $articulo['tipoiva']:0;
                    $lineas_factura->liquidolinea  = (isset($articulo['liquido'])) ? $articulo['liquido']:0;
                    $lineas_factura->brutolinea  = (isset($articulo['bruto'])) ? $articulo['bruto']:0;
                    $lineas_factura->descuentolinea  = (isset($articulo['desc'])) ? $articulo['desc']:0;
                    $lineas_factura->valorlinea  = (isset($articulo['valor'])) ? $articulo['valor']:0;
                    $lineas_factura->save();

            }

            foreach ($request['totales_por_iva'] as $totales)
            {
             
                if($totales['total_importe'] > 0 && $totales['total_iva'] > 0)
                {
                    $totalesiva = new TotalesPorIva;
                    $totalesiva->id_cabecera_factura = $cabecera_factura->id;
                    $totalesiva->id_cliente = $request['idcliente'];
                    $totalesiva->tipoiva = $totales['tipoiva'];
                    $totalesiva->porcentaje = $totales['porcentaje'];
                    $totalesiva->total_iva = $totales['total_iva'];
                    $totalesiva->total_importe = $totales['total_importe'];
                    $totalesiva->save();
                }
            }
            
            $data['cabecera_factura'] = $cabecera_factura;
            return $data;
           
           
            
        }catch(Exception $e){
                return response('Error',500);
        }     
    }


    public function listaFacturasTrimestre(Request $request)
    {
        try{
            
            switch ($request['trimestre']) {
                case '1':
                        return DB::select('exec ventas.lista_facturas_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa'],1,3]);
                    break;
                case '2':
                        return  DB::select('exec ventas.lista_facturas_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa'],4,6]);
                    break;
                case '3':
                        return  DB::select('exec ventas.lista_facturas_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa'],7,9]);
                    break;   
                case '4':
                        return  DB::select('exec ventas.lista_facturas_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa'],10,12]);
                    break;         
                default:
                    
                    break;
            }

      
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function listaFacturasTotalTrimestre(Request $request)
    {
        try{
            return DB::select('exec ventas.lista_facturas_total_por_trimeste ?', [date('Y')]);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

    public function getDatosFinancieros(Request $request)
    {
        try{
            return DB::select('exec ventas.get_datos_financieros ?', [$request['idalbaran']]);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

    public function listaLotesFacturaCliente(Request $request)
    {
        try{
            return DB::select('exec ventas.listar_lotes_excel ?,?', ['3','1']);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

    public function tipoFactura(Request $request)
    {
        try{
            return  DB::select('exec comun.tipo');
        }catch(Exception $e){
                return response('Error',500);
        }     
    }


    public function datosNuevaFactura(Request $request)
    {
        try{
            return DB::select('exec sistema.damecontador ?,?,?', ['VENTAS','NUMEROFACTURA','3']);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

	public function crearPdf(Request $request)
    {  
        return $this->generar_factura($request['facturacabecera'], $request['totalesiva'], $request['articulos']);
    }
  

}
