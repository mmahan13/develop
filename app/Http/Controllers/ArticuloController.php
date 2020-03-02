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

use App\Articulo;
use App\TiposIvas;
use App\Familia;
class ArticuloController extends Controller
{
	
    
    public function getListaArticulos(Request $request)
    {
        try{
            return  DB::select('exec comun.lista_articulos ? ',['3']);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getListaArticulosObsoletoNo(Request $request)
    {
        try{
            return  DB::select('exec comun.lista_articulos_obsoleto_no ?',['3']);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getListaArticulosSegunTarifaPrecio(Request $request)
    {
        try{
            return  DB::select('exec ventas.listar_articulos_sin_contrato ?,?',['1',$request['tarifaprecio']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function tiposIvas(Request $request)
    {
        try{
            return TiposIvas::orderby('porcentaje')->get();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function familiasArticulos(Request $request)
    {
        try{
            return Familia::orderby('codigofamilia')->get();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function updateIvaArticulo(Request $request)
    {
        try{
                $articulo = Articulo::find($request['idarticulo']);
                $articulo->grupoiva = $request['grupoiva'];
                $articulo->save();

                $articulo = [$articulo->codigoarticulo, $articulo->grupoiva];
                return $articulo;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function updateObsoleto(Request $request)
    {
        try{
                $articulo = Articulo::find($request['idarticulo']);
                $articulo->obsoleto = $request['obsoleto'];
                $articulo->save();

                $articulo = [$articulo->codigoarticulo, $articulo->obsoleto];
                return $articulo;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function updateArticulos(Request $request)
    {
        try{
                $articulo = Articulo::find($request['idarticulo']);
                $articulo->descripcionarticulo = $request['descripcionarticulo'];
                $articulo->precioventa = $request['precioventa'];
                $articulo->save();

                $articulo = [$articulo->codigoarticulo, $articulo->descripcionarticulo, $articulo->precioventa];
                return $articulo;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function nuevoArticulos(Request $request)
    {   
        try{
                $articulo = new Articulo;
                $articulo->codigoempresa = 1;
                $articulo->tipoarticulo = 'M';
                $articulo->codigoarticulo = Articulo::all()->max('codigoarticulo')+1;
                $articulo->codigoalternativo = Articulo::all()->max('codigoalternativo')+1;
                $articulo->descripcionarticulo = $request['descripcionarticulo'];
                $articulo->precioventa = $request['precioventa'];
                $articulo->codigoFamilia = $request['codigofamilia'];
                $articulo->codigoSubfamilia = $request['codigosubfamilia'];
                $articulo->preciocompra = $request['preciocompra'];
                $articulo->grupoiva = $request['grupoiva'];
                $articulo->obsoleto = $request['obsoleto'];
                $articulo->fechaalta = date('Ymd');
                $articulo->save();

             $datos = [$articulo->codigoarticulo, $articulo->descripcionarticulo, $articulo->precioventa];
            return $datos;

        }catch(Exception $e){
                return response('Error',500);
        }   
    }

	
}
