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

//cliente
use App\Cliente;
use App\Product;
use App\CabeceraFactura;
use App\LineasFactura;
use App\TiposIvas;
use App\TotalesPorIva;


class ClienteController extends Controller
{
	
    
    public function getListadoUsuarios()
    {
        try{
            $userid = auth()->user()->id;
            if($userid != 1){
                return Cliente::where('id_user', $userid)->orderby('id','desc')->get();
            }else{
                return Cliente::all();
            }
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getCliente(Request $request)
    {
        try{
          return Cliente::find($request['id_cliente']);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function totalesIvasFactura(Request $request)
    {   
        try{   

            return TotalesPorIva::where('id_cabecera_factura',$request['idfactura'])->get(); 
            
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }


    public function editarCliente(Request $request)
    {
        try{
          
            $cliente = Cliente::find($request['id']);
            $cliente->nombre = $request['nombre'];
            $cliente->apellidos = $request['apellidos'];
            $cliente->email = $request['email'];
            $cliente->telefono = $request['telefono'];
            $cliente->dni = $request['dni'];
            $cliente->direccion = $request['direccion'];
            $cliente->save();
            return $cliente;
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function crearCliente(Request $request)
    {
        try{
          $cliente = new Cliente;
          $cliente->id_user = auth()->user()->id;
          $cliente->nombre = $request['nombre'];
          $cliente->apellidos = $request['apellidos'];
          $cliente->email = $request['email'];
          $cliente->telefono = $request['telefono'];
          $cliente->dni = $request['dni'];
          $cliente->direccion = $request['direccion'];
          $cliente->save();
          return $cliente;
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function deleteCliente(int $id)
    {
        try{
          
            Cliente::find($id)->delete();
            $userid = auth()->user()->id;
            if($userid != 1){
                return Product::where('id_user', $userid)->orderby('id','desc')->get();
            }else{
                return Product::all();
            }
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }


    public function getProductos()
    {
        try{
            $userid = auth()->user()->id;
            if($userid != 1){
                return DB::select('call portal.get_productos(?)',[ $userid ]);
            }else{
                return  DB::select('call portal.get_new_productos()');
            }
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getIvas()
    {
        try{
            return  TiposIvas::All();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function crearProducto(Request $request)
    {
        try{
            $producto = new Product;
            $producto->id_user = auth()->user()->id;
            $producto->ref = $request['ref'];
            $producto->producto = $request['producto'];
            $producto->id_iva = $request['id'];
            $producto->save();
            return $producto;
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function editarProducto(Request $request)
    {
        try{
            $producto = Product::find($request['id']);
            $producto->ref = $request['ref'];
            $producto->producto = $request['producto'];
            $producto->id_iva = $request['id_iva'];
            $producto->save();
            return $producto;
        }catch(Exception $e){
                return response('Error',500);
        }   
    }
    
    public function deleteProducto(int $id)
    {
        try{
            Product::find($id)->delete();
            return  DB::select('call portal.get_productos');
            
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function facturasCliente(Request $request)
    {
        try{
            
            return CabeceraFactura::where('id_cliente',$request['idcliente'])->get();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function listaFacturas()
    {
        try{
            $userid = auth()->user()->id;
            if($userid != 1){
                return CabeceraFactura::where('id_user', $userid)->get();
            }else{
                return CabeceraFactura::all();
            }
            
           
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function lineasFacturas(Request $request)
    {   
        try{    
            
             return LineasFactura::where('id_cabecera_factura', $request['idfactura'])->get();
        
        }catch(Exception $e){
          return response('Error',500);
        }   
    }
    

    /* public function getDomiciliosClientes(Request $request)
    {
        try{
            return  Domicilio::where('codigocliente', $request['codigocliente'])->get();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function getCodigosPostales(Request $request)
    {
        try{
            return Sigla::all();
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    

    

    public function informeAnualFacturas(Request $request)
    {
        try{
            return  DB::select('exec ventas.get_users ?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function informeTrimestralFacturas(Request $request)
    {
        try{
            return  DB::select('exec ventas.informe_trimestral_facturas ?,?,?',[date('Y'),$request['codigocliente'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function comprasClientes(Request $request)
    {
        try{
            return  DB::select('exec ventas.compras_clientes ?,?',[$request['codigocliente'],$request['codigoempresa']]);
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function nuevoCliente(Request $request)
    {
      try{
            
              //print_r($request[1]); exit;
              $cliente = new Cliente;
              $cliente->codigoempresa = $request[0]['codigoempresa'];
              $cliente->codigocliente = (Cliente::all()->max('codigocliente')+ 1);
              $cliente->razonsocial = $request[0]['razonsocial'];
              $cliente->siglanacion = 'ES';
              $cliente->nombre1 = $request[0]['nombre1'];
              $cliente->cargo1 = $request[0]['cargo1'];
              $cliente->codigobanco = $request[0]['codigobanco'];
              $cliente->iban = $request[0]['iban'];
              $cliente->cifdni = $request[0]['cifdni'];
              $cliente->email1 = $request[0]['email1'];
              $cliente->email2 = $request[0]['email2'];
              $cliente->fechaalta =  date("Ymd");  
              $cliente->porretencion = $request[0]['porretencion'];
              $cliente->save();


              $domicilio = new Domicilio;
              $domicilio->codigoempresa = $cliente->codigoempresa;
              $domicilio->codigocliente = $cliente->codigocliente;
              $domicilio->idcliente = $cliente->idcliente;
              $domicilio->tipodomicilio = $request[1]['tipodomicilio'];
              $domicilio->domicilio = $request[1]['codigosigla'].'/'.$request[1]['viapublica'].','.$request[1]['numero1'];
              $domicilio->tipoportes = $request[1]['tipoportes'];
              $domicilio->codigosigla = $request[1]['codigosigla'];
              $domicilio->viapublica = $request[1]['viapublica'];
              $domicilio->numero1 = $request[1]['numero1'];
              $domicilio->numero2 = '';
              $domicilio->codigopostal = $request[1]['codigopostal'];
              $domicilio->poblacionid = $request[1]['poblacionid'];
              $domicilio->poblacion = $request[1]['poblacion'];
              $domicilio->provinciaid = $request[1]['provinciaid'];
              $domicilio->provincia = $request[1]['provincia'];
              $domicilio->codigonacion = $request[1]['codigonacion'];
              $domicilio->nacion = $request[1]['nacion'];
              $domicilio->telefono = $request[1]['telefono'];
              $domicilio->save();

              $domicilio = new Domicilio;
              $domicilio->codigoempresa = $cliente->codigoempresa;
              $domicilio->codigocliente = $cliente->codigocliente;
              $domicilio->idcliente = $cliente->idcliente;
              $domicilio->tipodomicilio = 'E';
              $domicilio->domicilio = $request[1]['codigosigla'].'/'.$request[1]['viapublica'].','.$request[1]['numero1'];
              $domicilio->tipoportes = $request[1]['tipoportes'];
              $domicilio->codigosigla = $request[1]['codigosigla'];
              $domicilio->viapublica = $request[1]['viapublica'];
              $domicilio->numero1 = $request[1]['numero1'];
              $domicilio->numero2 = '';
              $domicilio->codigopostal = $request[1]['codigopostal'];
              $domicilio->poblacionid = $request[1]['poblacionid'];
              $domicilio->poblacion = $request[1]['poblacion'];
              $domicilio->provinciaid = $request[1]['provinciaid'];
              $domicilio->provincia = $request[1]['provincia'];
              $domicilio->codigonacion = $request[1]['codigonacion'];
              $domicilio->nacion = $request[1]['nacion'];
              $domicilio->telefono = $request[1]['telefono'];
              $domicilio->save();

              return Cliente::find($cliente->id);
              
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

    public function editarCliente(Request $request)
    {
        try{
          
            $editar_cliente = Cliente::find($request['id']);
            $editar_cliente->razonsocial = $request['razonsocial'];
            $editar_cliente->cifdni = $request['cifdni'];
            $editar_cliente->email1 = $request['email1'];
            $editar_cliente->iban = $request['iban']; 
            $editar_cliente->comentarios = $request['comentarios'];
            $editar_cliente->save();

            $editar_domicilio = Domicilio::where('codigocliente', $editar_cliente->codigocliente)->first();
            $editar_domicilio->domicilio = $request['domicilio'];
            $editar_domicilio->numero1 = $request['numero1'];
            $editar_domicilio->codigopostal = $request['codigopostal'];
            $editar_domicilio->provincia = $request['provincia']; 
            $editar_domicilio->poblacion = $request['poblacion'];
            $editar_domicilio->save();

            return DB::select('exec lista_clientes');
        }catch(Exception $e){
                return response('Error',500);
        }   
    }

   
    public function uploadLogo(Request $request)
    {
        if ($request->input('extension') === 'png') {
             return response('no se ha podido guardar el logotipo', 500);
        }
        try {
                if ($request->input('extension') === 'jpg') {
                    $request->file->storeAs('logotipos', $request->input('id'), 'local');

                   
                }
                return response(base64_encode(Storage::disk('local')->get('logotipos/' . $request->input('id'))), 200);

            } catch (Exception $exception) {
                return response('no se ha podido guardar el logotipo', 500);
            }

    }*/
	
}
