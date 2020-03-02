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


class ResumenController extends Controller
{
	
    public function resumenEmitidas(Request $request)
    {
        try{
            return DB::select('exec ventas.lista_facturas_total_por_trimeste ?', [date('Y')]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function resumenRecibidas(Request $request)
    {
        try{
             return DB::select('exec compras.lista_presupuestos_total_por_trimeste ?', [date('Y')]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
  
	
}
