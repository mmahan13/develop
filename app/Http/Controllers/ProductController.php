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

use App\Product;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductos()
    {
        try{
            return  DB::select('call portal.get_productos');
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
}
