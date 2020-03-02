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

use App\Empresa;

class EmpresaController extends Controller
{
	
    
    public function getListaEmpresas(Request $request)
    {
        try{
            return  Empresa::all();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

   




   

	
}
