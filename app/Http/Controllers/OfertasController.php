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

use App\Oferta;
use App\LineaOferta;

class OfertasController extends Controller
{
	use PdfTrait;
    

    /*public function listaFacturas(Request $request)
    {	
    	try{	

	   		 return DB::select('exec ventas.listado_facturas ?',[3]);
		
		}catch(Exception $e){
          return response('Error',500);
        }   
	

    public function lineasFacturas(Request $request)
    {   
        try{    
             return DB::select('exec ventas.listado_lineas_factura ?', [$request['idfactura']]);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function totalesIvasFactura(Request $request)
    {   
        try{   

            return DB::select('exec ventas.totales_iva_factura ?', [$request['idfactura']]);
        
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
    }  */

    public function lineasOfertas(Request $request)
    {  
        try{    

             return LineaOferta::where('idoferta', $request['idoferta'])->get();
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function totalesIvasOfertas(Request $request)
    {   
        try{   
            return DB::select('exec ventas.totales_iva_ofertas ?', [$request['idoferta']]);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function getOfertasCliente(Request $request)
    {
        try{
            return  DB::select('exec ventas.listado_ofertas ?',[3]);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

 
     public function guardarOferta(Request $request)
    {
        try{
            print_r($request->all()); exit;
            $parametros = [
                $request['idcliente'], 
                (isset($request['serieoferta'])) ? $request['serieoferta']:'',
                (isset(auth()->user()->id)) ? auth()->user()->id:0, 
                (isset($request['fecha'])) ? $request['fecha']: date('Ymd'),
                (isset($request['descripcionoferta'])) ? $request['descripcionoferta']:'',
                (isset($request['tipoOferta'])) ? $request['tipoOferta']: 1,
                (isset($request['pordescuento'])) ? $request['pordescuento']:0,
                (isset($request['porretencion'])) ? $request['porretencion']:0,
                

            ];

            $cabecera = DB::select('exec ventas.crea_cabecera_oferta ?,?,?,?,?,?,?,?',[$parametros[0],$parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],$parametros[6],$parametros[7]]);
           

            foreach ($cabecera as $cab => $clave){
                $idfactura = $clave->idfactura;
            }

            foreach ($request['articulos'] as $articulo) {
                $descuento = ($articulo['descuento'] == 0) ? 0: $articulo['descuento'];
                 $parametros = [
                        $idfactura,
                        (isset($articulo['codigoarticulo'])) ? $articulo['codigoarticulo']:0, 
                        (isset($articulo['descripcionarticulo'])) ? $articulo['descripcionarticulo']:'',
                        (isset($articulo['descripcionlinea'])) ? $articulo['descripcionlinea'] : '',
                        (isset($articulo['cantidad'])) ? $articulo['cantidad']:0, 
                        (isset($articulo['precioventa'])) ?$articulo['precioventa']:0, 
                        (isset($descuento)) ? $descuento:0, 
                        (isset($articulo['codigoalmacen'])) ? $articulo['codigoalmacen']:0,
                        (isset($articulo['descripcionfactura'])) ? $articulo['descripcionfactura']:0,
                        (isset($articulo['partida'])) ? $articulo['partida']:'',
                        (isset($articulo['fechacaduca'])) ? $articulo['fechacaduca']:null,
                        (isset($articulo['ubicacion '])) ? $articulo['ubicacion ']:'',

                   ]; 
            DB::select('exec ventas.crea_linea_factura ?,?,?,?,?,?,?,?,?,?,?,?',[$parametros[0],$parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],$parametros[6],$parametros[7],$parametros[8],$parametros[9],$parametros[10],$parametros[11]]);
            }
            $datos = [$idfactura];
            
            DB::select('exec ventas.actualiza_importe_facturas_todos ?',[$datos[0]]);
            return response('Factura creada',200);
           
        
            
        }catch(Exception $e){
                return response('Error',500);
        }     
    }
     public function tipoOferta(Request $request)
    {
        try{
            return  DB::select('exec comun.tipo');
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

    public function numeroOferta(Request $request)
    {
        try{
            return DB::select('exec sistema.damecontador ?,?,?', ['VENTAS','NUMEROOFERTA','3']);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

	public function crearPdf(Request $request)
    {  
        //print_r($request->all()); exit;
        return $this->generar_factura($request['facturacabecera'], $request['totalesiva'], $request['articulos']);

       
    }
  

}
