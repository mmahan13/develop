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

use App\Proveedor;
use App\DomicilioProveedor;
use App\Traits\MuranoTrait;

class PresupuestoController extends Controller
{
	use PdfTrait;
    use MuranoTrait;
    public function listarFacturaProveedor(Request $request)
    {   
        try{    
             return DB::select('exec compras.listado_facturas ?',['3']);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function listarGastosProveedor(Request $request)
    {   
        try{    
             return DB::select('exec compras.listado_gastos ?',['3']);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function lineasFacturaProveedor(Request $request)
    {   
        try{    
             return DB::select('exec compras.lineas_factura_proveedor ?', [$request['idfactura']]);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function listaProveedorPresupuesto(Request $request)
    {   
        try{    
             return  DB::select('exec compras.lista_presupuestos_proveedores ?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa']]);
             
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function totalesIvasFacturasProveedores(Request $request)
    {   
        try{    
            return DB::select('exec compras.listar_ivas_factura ?', [$request['idfactura']]);
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }

    public function articulosProveedor(Request $request)
    {
        try{
            return  DB::select('exec compras.articulos_proveedor ?,?',[$request['codigoproveedor'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getListaProveedores(Request $request)
    {
        try{
            //return Proveedor::orderby('created_at','desc')->get(['id','idproveedor','codigoempresa','codigoproveedor','cifdni', 'razonsocial','email1']);
            return  DB::select('exec comun.lista_proveedores ?',['3']);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    
    public function numeroPresupuesto(Request $request)
    {
        try{
            //return DB::select('exec ges.dame_presupuesto');
            $portal = 'COMPRAS';
            $contador = 'NUMPRESUPUESTO';
            $emp = 1;
            return DB::select('exec sistema.damecontador ?, ?, ?', [$portal,$contador,$emp]);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

     public function getCabeceraIvas(Request $request)
    {
        try{
           $d['ivas'] = DB::select('exec comun.get_base_ivas');
           $d['tipoFactura'] = DB::select('exec comun.tipo_factura');
           return $d;
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    


    public function nuevoProveedor(Request $request)
    {
      try{
            print_r($request->all()); exit;
            $proveedor = new Proveedor;
            $proveedor->codigoempresa = 1;
            $proveedor->codigoproveedor = (Proveedor::all()->max('codigoproveedor')+ 1);
            $proveedor->razonsocial = $request['razonsocial'];
            $proveedor->siglanacion = 'ES';
            $proveedor->cifdni = $request['cifdni'];
            $proveedor->email1 = $request['email1'];
            $proveedor->fechaalta =  date("Ymd");  
            $proveedor->comentarios = $request['comentarios'];
            $proveedor->logoempresa = $request['logoempresa'];
            $proveedor->save();

            $domicilio = new DomicilioProveedor;
            $domicilio->codigoempresa = $proveedor->codigoempresa;
            $domicilio->codigoproveedor = $proveedor->codigoproveedor;
            $domicilio->numerodomicilio = 0;
            $domicilio->tipodomicilio = 'F';
            $domicilio->tipoportes = 'D';
            $domicilio->codigosigla = $request['codigosigla'];
            $domicilio->viapublica = $request['direaccion'];
            $domicilio->numero1 = $request['numero1'];
            $domicilio->codigopostal = $request['codigopostalid'];
            $domicilio->poblacionid = $request['poblacionid'];
            $domicilio->poblacion = $request['poblacion'];
            $domicilio->provinciaid = $request['provinciaid'];
            $domicilio->provincia = $request['provincia'];
            $domicilio->telefono = $request['telefono'];
            $domicilio->save();

            return Proveedor::find($proveedor->id);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function informeAnualPresupuestos(Request $request)
    {
        try{
            return  DB::select('exec compras.informe_anual_presupuestos ?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function informeTrimestralPresupuestos(Request $request)
    {
        try{
            return  DB::select('exec compras.informe_trimestral_presupuestos ?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function listaPresupuestosTrimestre(Request $request)
    {
        try{
            
            switch ($request['trimestre']) {
                case '1':
                        return DB::select('exec compras.lista_presupuestos_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa'],1,3]);
                    break;
                case '2':
                        return  DB::select('exec compras.lista_presupuestos_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa'],4,6]);
                    break;
                case '3':
                        return  DB::select('exec compras.lista_presupuestos_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa'],7,9]);
                    break;   
                case '4':
                        return  DB::select('exec compras.lista_presupuestos_por_trimeste ?,?,?,?,?',[date('Y'),$request['codigoproveedor'],$request['codigoempresa'],10,12]);
                    break;         
                default:
                    
                    break;
            }

      
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

     public function listaPresupuestosTotalTrimestre(Request $request)
    {
        try{
            return DB::select('exec compras.lista_presupuestos_total_por_trimeste ?', [date('Y')]);
        }catch(Exception $e){
                return response('Error',500);
        }     
    }


    public function guardarFacturaConArticulos(Request $request)
    {
        try{
           
            $parametros = [
                $request['cabecera'][0]['idproveedor'], 
                $request['cabecera'][0]['numero_factura'], 
                (isset($request['cabecera'][0]['fecha_formateada'])) ? $request['cabecera'][0]['fecha_formateada']:date('Ymd'), 
                (isset($request['cabecera'][0]['serie'])) ? $request['cabecera'][0]['serie']: '', 
                (isset($request['cabecera'][0]['descripcion_factura'])) ? $request['cabecera'][0]['descripcion_factura']: '', 
                0,
                0,
                0,
                0,
                (isset($request['cabecera'][0]['pordescuento'])) ? $request['cabecera'][0]['pordescuento']:0,
                (isset($request['cabecera'][0]['porretencion'])) ? $request['cabecera'][0]['porretencion']:0,
                //(isset($request['cabecera'][0]['recargoequivalencia'])) ? $request['cabecera'][0]['recargoequivalencia']: 0,
                (isset($request['cabecera'][0]['tipofactura'])) ? $request['cabecera'][0]['tipofactura']:1,
                (isset(auth()->user()->id)) ? auth()->user()->id:0 
           ]; 

          
            $cabeceraFactura = DB::select('exec compras.crea_cabecera_factura ?,?,?,?,?,?,?,?,?,?,?,?,?',[$parametros[0], $parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],$parametros[6],$parametros[7],$parametros[8],$parametros[9], $parametros[10],$parametros[11], $parametros[12]]);  


            if($cabeceraFactura[0]->valor == 0)
            {
                foreach ($cabeceraFactura as $cab => $clave)
                {
                    $idfactura = $clave->idfactura;
                    if(isset($idfactura)){
                        $cabecera_actura = DB::select('exec compras.actualiza_importe_cabecera_factura ?',[$idfactura]);
                    }
                }

                foreach ($request['articulos'] as $articulo) 
                {

                    $parametros = [
                            $idfactura,
                            $articulo['codigoarticulo'], 
                            $articulo['descripcionarticulo'],
                            $articulo['descripcionlinea'],  
                            $articulo['cantidad'], 
                            $articulo['preciocompra'], 
                            $articulo['descuento'], 
                            '',
                    ]; 
                    
                    DB::select('exec compras.crea_linea_factura ?,?,?,?,?,?,?,?',[$parametros[0],$parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],$parametros[6],$parametros[7]]);
             
                } 
                return $cabecera_actura;     
            }
            if($cabeceraFactura[0]->valor == 1 || $cabeceraFactura[0]->valor == 2)
            {
                 return response('Error',500);
            }
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

    public function presupuestoGuardarCabeceraFactura(Request $request)
    {
        try{

            foreach ($request->all() as $dato) {
               $parametros = [
                        $dato['idproveedor'], 
                        (isset($dato['numero_factura'])) ? $dato['numero_factura']: '', 
                        (isset($dato['fecha_formateada'])) ? $dato['fecha_formateada']:date('Ymd'), 
                        (isset($dato['serie'])) ? $dato['serie']:'', 
                        (isset($dato['descripcion_factura'])) ? $dato['descripcion_factura']:'', 
                        (isset($dato['baseiva'])) ? $dato['baseiva']:0,
                        (isset($dato['baseiva2'])) ? $dato['baseiva2']:0,
                        (isset($dato['baseiva3'])) ? $dato['baseiva3']:0,
                        (isset($dato['baseivaexento'])) ? $dato['baseivaexento']:0,
                        (isset($dato['pordescuento'])) ? $dato['pordescuento']:0,
                        (isset($dato['porretencion'])) ? $dato['porretencion']:0,
                        (isset($dato['tipofactura'])) ? $dato['tipofactura']:1,
                        (isset(auth()->user()->id)) ? auth()->user()->id:0
                   ]; 
         //print_r($parametros); exit;
        DB::select('exec compras.crea_cabecera_factura ?,?,?,?,?,?,?,?,?,?,?,?,?',[$parametros[0], $parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],$parametros[6],$parametros[7],$parametros[8],$parametros[9], $parametros[10],$parametros[11],$parametros[12]]);   
            }       
            
           
            
        }catch(Exception $e){
                return response('Error',500);
        }     
    }

	
    public function crearPdfFacturaProveedor(Request $request)
    {  
      //print_r($request->all()); exit;
    return $this->generar_factura_proveedor($request['presupuestocabecera'], $request['totalesiva'], $request['articulos']);

       
    }
   

}
