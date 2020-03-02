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
use DPDF;
use App\libraries\PdfInvoice;
use Carbon\Carbon;

use App\Plan;
use App\CabeceraPlan;
use App\NuevaLineaContrato;
use App\Contrato;
use App\LineasContrato;

class ContratosController extends Controller
{
	
    public function getContratos(Request $request)
    {
        try{
            return DB::select('exec contratos.get_cabeceras_contrato');
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.get_contrato ?',[$request['idalbaran']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getLineasContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.listar_lineascontrato ?', [$request['idcontrato']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    
    public function getPlanContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.listar_cabeceraplan ?', [$request['idcontrato']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getDetallePlan(Request $request)
    {
        try{
            return DB::select('exec contratos.listar_lineasplan ?', [$request['idplan']]);
            //return Plan::where('idplan', $request['idplan'])->get();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    

    public function aniadirLineasContrato(Request $request)
    {
        try{
               
            $articulos = $request->all();
            foreach ($articulos as $articulo) 
            {
                DB::statement('exec contratos.add_linea_nueva ?,?,?,?,?',[$articulo['idcontrato'],$articulo['unidades'],$articulo['pordescuento'],$articulo['codigoarticulo'],$articulo['precio']]);
            }   

            $datos_contrato['cabecera_contrato'] = DB::select('exec contratos.listar_cabeceracontrato ?', [$articulos[0]['idcontrato']]);
            $datos_contrato['lineas_contrato'] = DB::select('exec contratos.listar_lineascontrato ?', [$articulos[0]['idcontrato']]);
                
            return $datos_contrato;


        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function activarContrato(Request $request)
    {
        try{

            $cabecera_contrato = Contrato::where('idcontrato',$request['idcontrato'])->first();
            $cabecera_contrato->estado = $request['estado'];
            if($request['estado'] == 1 && $cabecera_contrato->fechaactivacion == null)
            {
                $cabecera_contrato->fechaactivacion = Carbon::createFromFormat('d/m/Y',$request['fechainicio']);
            }
            $cabecera_contrato->save();

            $lineas_contrato = LineasContrato::where('idcontrato',$request['idcontrato'])->first();

            if(isset($lineas_contrato))
            {
                DB::select('exec contratos.actualiza_importes_todos ?',[$request['idcontrato']]);
                DB::select('exec contratos.procesa_planescontratos ?',[$request['idcontrato']]);
            }
            return $cabecera_contrato;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function activarDesactivarLineaArticuloContrato(Request $request)
    {
        try{
            
            $linea_contrato = LineasContrato::where('idcontrato',$request['idcontrato'])->where('idlineacontrato',$request['idlineacontrato'])->first();
            $linea_contrato->bajalinea = $request['bajalinea'];
            $linea_contrato->save();

            DB::select('exec contratos.actualiza_importes_todos ?',[$request['idcontrato']]);
            DB::select('exec contratos.procesa_planescontratos ?',[$request['idcontrato']]);

            return DB::select('exec contratos.listar_cabeceracontrato ?', [$request['idcontrato']]);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function cambiarFechaLineaContrato(Request $request)
    {
        try{
            //print_r($request->all()); exit;
            $linea_contrato = LineasContrato::where('idcontrato',$request['idcontrato'])->where('idlineacontrato',$request['idlineacontrato'])->first();
            if($request['inicio'] == 0 && isset($request['fechainicio'])){
                $linea_contrato->fechainicio = Carbon::createFromFormat('d/m/Y', $request['fechainicio']);
                $linea_contrato->save();
            }
            if($request['inicio'] == 1 && isset($request['fechafin'])){
                $linea_contrato->fechafinal = Carbon::createFromFormat('d/m/Y', $request['fechafin']);
                $linea_contrato->save();
            }
            
            DB::select('exec contratos.procesa_planescontratos ?',[$request['idcontrato']]);

            return response('Actualizada la fecha',200);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }



    public function renuevaContrato(Request $request)
    {
        try{
            $cabecera_contrato = Contrato::where('idcontrato',$request['idcontrato'])->first();
            $cabecera_contrato->renueva = $request['renueva'];
            $cabecera_contrato->save();
            return $cabecera_contrato;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function nuevoContrato(Request $request)
    {
        try{
             $idcontrato = DB::select('exec contratos.crea_cabecera_nuevocontrato ?', [$request['idcliente']]);
             return DB::select('exec contratos.get_cabeceracontrato ?', [$idcontrato[0]->idcontrato]);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    
    public function editarLineaContrato(Request $request)
    {
        try{
           
            $lineas_contrato = LineasContrato::where('idcontrato',$request['idcontrato'])->where('idlineacontrato',$request['idlineacontrato'])->first();
            $lineas_contrato->unidades = $request['unidades'];
            $lineas_contrato->pordescuento = $request['pordescuento'];
            $lineas_contrato->precio = $request['precio'];
            $lineas_contrato->save();
            
            DB::select('exec contratos.actualiza_importes_todos ?',[$request['idcontrato']]);
            DB::select('exec contratos.procesa_planescontratos ?',[$request['idcontrato']]);

            $d['cabecera_contrato'] = DB::select('exec contratos.listar_cabeceracontrato ?', [$request['idcontrato']]);
            $d['lineas_contrato'] = DB::select('exec contratos.listar_lineascontrato ?', [$request['idcontrato']]);
            return $d;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function editarCabeceraContrato(Request $request)
    {
        try{
            
            $cabecera_contrato = Contrato::where('idcontrato',$request['idcontrato'])->first();
            $cabecera_contrato->pordescuento = $request['pordescuento'];
            $cabecera_contrato->save();
           
            DB::select('exec contratos.actualiza_importes_todos ?',[$request['idcontrato']]);
            DB::select('exec contratos.procesa_planescontratos ?',[$request['idcontrato']]);

            $d['cabecera_contrato'] = DB::select('exec contratos.listar_cabeceracontrato ?', [$request['idcontrato']]);
            $d['lineas_contrato'] = DB::select('exec contratos.listar_lineascontrato ?', [$request['idcontrato']]);
            return $d;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }


    public function getPendientesFacturacion(Request $request)
    {
        try{
            $fechai = Carbon::createFromFormat('d/m/Y', $request['fechai']);
            $fechaf = Carbon::createFromFormat('d/m/Y', $request['fechaf']);
            return DB::select('exec contratos.get_planes_contratos_pendientes_facturar ?,?', [$fechai,$fechaf]);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function creaFacturaDesdeContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.creaalbaran_desdecontrato ?', [$request['idplan']]);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function facturarTodasDesdeContrato(Request $request)
    {
        try{
            $fechai = Carbon::createFromFormat('d/m/Y', $request['fechai']);
            $fechaf = Carbon::createFromFormat('d/m/Y', $request['fechaf']);
            return DB::select('exec contratos.generar_facturas_desde_contrato_con_fechas  ?,?', [$fechai,$fechaf]);

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function addFechaActivacionContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.modificar_fechaactivacion_cabecera ?,?', [$request['idcontrato'],$request['fechaactivacion']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function cambiarFechaActivacionLineaContrato(Request $request)
    {
        try{
            return DB::select('exec contratos.modificar_fechaactivacion_linea ?,?', [$request['idlineacontrato'],$request['factivacion']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function tienePlanFacturado(Request $request)
    {
        try{
            $procesado = CabeceraPlan::where('idcontrato',$request['idcontrato'])->get(['procesado']);
            foreach ($procesado as $clave => $value) {
                if($value->procesado == 1){
                    return 1;
                }else{
                    return 0;
                }
            }
           
           
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
	
}
