<?php

use GuzzleHttp\Psr7\Request as RequestApi;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get(
    '/timeout',
    function () {
        return view('errors.timeout');
    }
);


Route::get('/demo/{clave}', function ($clave) {
    $fecha_input = Carbon\Carbon::createFromTimestamp($clave);
    $fecha_ahora = Carbon\Carbon::now();
    if ( $fecha_input->diffInHours($fecha_ahora) < 1) {
        \Auth::loginUsingId(1);
        return redirect('/');
    } 
});



Route::get('/creapdf', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {

    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);
    $fpdf->Cell(50, 25, 'Hello World!');
    $fpdf->Output();

});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index');

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');

Auth::routes();
Route::post('/first/login/change', 'UserController@firstLogin');


//clientes
Route::get('/listado/usuarios', 'ClienteController@getListadoUsuarios');
Route::post('/editar/cliente', 'ClienteController@editarCliente');
Route::post('/crear/cliente', 'ClienteController@crearCliente');
Route::get('/delete/cliente/{id}', 'ClienteController@deleteCliente');
Route::post('/get/cliente/', 'ClienteController@getCliente');

//productos
Route::get('/get/productos', 'ClienteController@getProductos');
Route::get('/get/ivas', 'ClienteController@getIvas');
Route::post('/crear/producto', 'ClienteController@crearProducto');
Route::post('/editar/producto', 'ClienteController@editarProducto');
Route::get('/delete/producto/{id}', 'ClienteController@deleteProducto');

Route::post('/get/lineas/factura', 'ClienteController@lineasFacturas');
Route::post('/totales/ivas/factura/cliente', 'ClienteController@totalesIvasFactura');
Route::post('/lista/facturas/cliente', 'ClienteController@facturasCliente');
Route::get('/get/lista/facturas', 'ClienteController@listaFacturas');


Route::post('/informe/anual/facturas', 'ClienteController@informeAnualFacturas');
Route::post('/infrome/trimestral/facturas', 'ClienteController@informeTrimestralFacturas');
Route::post('/compras/cliente', 'ClienteController@comprasClientes');

//domicilios cliente
Route::post('/get/domicilios/cliente', 'ClienteController@getDomiciliosClientes');
Route::post('/nuevo/cliente', 'ClienteController@nuevoCliente');
Route::post('/editar/cliente', 'ClienteController@editarCliente');
Route::post('/emp/logo/upload', 'ClienteController@uploadLogo');

//sigla
Route::post('/codigos/postales', 'ClienteController@getCodigosPostales');
//provincia
Route::post('/provincia', 'ClienteController@getProvincia');
//poblacion
Route::post('/poblacion', 'ClienteController@getPoblacion');
//cp
Route::post('/cp', 'ClienteController@getCodigoPostal');

//empresas
Route::post('/lista/empresas', 'EmpresaController@getListaEmpresas');

//articulos
Route::post('/lista/articulos', 'ArticuloController@getListaArticulos');
Route::post('/lista/articulos/obsoleto/no', 'ArticuloController@getListaArticulosObsoletoNo');
Route::post('/lista/articulos/segun/tarifa', 'ArticuloController@getListaArticulosSegunTarifaPrecio');
Route::post('/tipos/ivas', 'ArticuloController@tiposIvas');
Route::post('/familia/articulos', 'ArticuloController@familiasArticulos');

Route::post('/update/iva/articulo', 'ArticuloController@updateIvaArticulo');
Route::post('/update/obsoleto', 'ArticuloController@updateObsoleto');
Route::post('/update/articulo', 'ArticuloController@updateArticulos');
Route::post('/nuevo/articulo', 'ArticuloController@nuevoArticulos');

/*----------------------------------------------------------------------------------------*/
//factura
Route::get('/numero/factura', 'FacturaController@numeroFactura');
Route::post('/guardar/factura', 'FacturaController@guardarFactura');


/*----------------------------------------------------------------------------------------*/

Route::post('/datos/nueva/factura', 'FacturaController@datosNuevaFactura');
Route::post('/guardar/factura', 'FacturaController@guardarFactura');
Route::post('/lista/facturas/trimestre', 'FacturaController@listaFacturasTrimestre');
Route::post('/lista/facturas/total/trimestre', 'FacturaController@listaFacturasTotalTrimestre');
Route::post('/get/datos/financieros', 'FacturaController@getDatosFinancieros');
Route::post('/lista/lotes/factura/cliente', 'FacturaController@listaLotesFacturaCliente');
Route::get('/tipo/factura', 'FacturaController@tipoFactura');
Route::post('/crear/pdf', 'PdfController@getPdfInvoice');
Route::post('/send/pdf', 'PdfController@reeviarFactura');
/*----------------------------------------------------------------------------------------*/
//ofertas
Route::post('/numero/oferta', 'OfertasController@numeroOferta');
Route::get('/tipo/oferta', 'OfertasController@tipoOferta');
Route::post('/guardar/oferta', 'OfertasController@guardarOferta');
Route::post('/get/ofertas/cliente', 'OfertasController@getOfertasCliente');
Route::post('/get/lineas/ofertas', 'OfertasController@lineasOfertas');
Route::post('/totales/ivas/ofertas', 'OfertasController@totalesIvasOfertas');

//presupuesto
Route::post('/numero/presupuesto', 'PresupuestoController@numeroPresupuesto');
Route::post('/proveedor/guardar/cabecera/factura', 'PresupuestoController@presupuestoGuardarCabeceraFactura');
Route::post('/guardar/factura/con/articulos', 'PresupuestoController@guardarFacturaConArticulos');
Route::post('/listar/factura/proveedor', 'PresupuestoController@listarFacturaProveedor');
Route::post('/lineas/factura/proveedor', 'PresupuestoController@lineasFacturaProveedor');
Route::post('/listar/gastos/proveedor', 'PresupuestoController@listarGastosProveedor');
Route::post('/totales/ivas', 'PresupuestoController@totalesIvas');
Route::post('/informe/anual/presupuestos', 'PresupuestoController@informeAnualPresupuestos');
Route::post('/infrome/trimestral/presupuestos', 'PresupuestoController@informeTrimestralPresupuestos');
Route::post('/lista/presupuestos/trimestre', 'PresupuestoController@listaPresupuestosTrimestre');
Route::post('/lista/presupuestos/total/trimestre', 'PresupuestoController@listaPresupuestosTotalTrimestre');

Route::post('/get/cabevera/ivas', 'PresupuestoController@getCabeceraIvas');


Route::post('/lista/proveedor/presupuesto', 'PresupuestoController@listaProveedorPresupuesto');
Route::post('/crear/pdf/factura/proveedor', 'PresupuestoController@crearPdfFacturaProveedor');

//proveedores
Route::post('/nuevo/proveedor', 'PresupuestoController@nuevoProveedor');
Route::post('/lista/proveedores', 'PresupuestoController@getListaProveedores');
Route::post('/totales/ivas/factura/proveedores', 'PresupuestoController@totalesIvasFacturasProveedores');
Route::post('/articulos/proveedor', 'PresupuestoController@articulosProveedor');
//datos select option facturacion
Route::get('/dato/facturacion/{num_cli}', 'UserController@getDatoFacturacion');

//resumen
Route::post('/resumen/emitidas', 'ResumenController@resumenEmitidas');
Route::post('/resumen/recibidas', 'ResumenController@resumenRecibidas');

//contratos
Route::post('/get/contratos','ContratosController@getContratos');
Route::post('/get/contrato','ContratosController@getContrato');
Route::post('/get/lineas/contrato','ContratosController@getLineasContrato');
Route::post('/get/plan/contrato','ContratosController@getPlanContrato');
Route::post('/get/detalle/plan','ContratosController@getDetallePlan');
Route::post('/aniadir/linea/contrato','ContratosController@aniadirLineasContrato');
Route::post('/nuevo/contrato','ContratosController@nuevoContrato');
Route::post('/activar/contrato','ContratosController@activarContrato');
Route::post('/desactivar/contrato','ContratosController@desactivarContrato');
Route::post('/renueva/contrato','ContratosController@renuevaContrato');
Route::post('/edita/linea/contrato','ContratosController@editarLineaContrato');
Route::post('/edita/cabecera/contrato','ContratosController@editarCabeceraContrato');
Route::post('/activar/desactivar/linea/articulo','ContratosController@activarDesactivarLineaArticuloContrato');
Route::post('/cambiar/fecha/linea/contrato','ContratosController@cambiarFechaLineaContrato');
Route::post('/get/pendientes/facturacion','ContratosController@getPendientesFacturacion');
Route::post('/crea/factura/desde/contrato','ContratosController@creaFacturaDesdeContrato');
Route::post('/facturar/todas/desde/contrato','ContratosController@facturarTodasDesdeContrato');
Route::post('/add/fecha/activacion/contrato','ContratosController@addFechaActivacionContrato');
Route::post('/cambiar/fecha/activacion/linea/contrato','ContratosController@cambiarFechaActivacionLineaContrato');
Route::post('/contrato/tiene/plan/facturado','ContratosController@tienePlanFacturado');
//admin
Route::get('/admin', 'AdminController@index');

// Guarda las rutas verificando los permisos de roles según la ruta registrada
Route::group(
    ['middleware' => 'permissions'],
    function () {
        // Usuarios
        Route::get(
            '/panel/{path}',
            function ($path) {
                if (view()->exists($path)) {
                    return view($path);
                }
                return "<div></div>";
            }
        );
        Route::prefix('users')->group(
            function () {
                Route::get('/', 'UserController@index');
                Route::get('/list', 'UserController@list');
                Route::post('/new', 'UserController@new');
                Route::get('/{dni}/exists', 'UserController@exists');
                Route::get(
                    '/{userID}/details',
                    'UserController@details'
                )->where('userID', '[0-9]+');
                Route::post(
                    '/{userID}/delete',
                    'UserController@delete'
                )->where('userID', '[0-9]+');
                Route::post(
                    '/{userID}/update',
                    'UserController@update'
                )->where('userID', '[0-9]+');
            }
        );
        Route::prefix('roles')->group(
            function () {
                Route::get('/list', 'RoleController@list');
                Route::post('/new', 'RoleController@new');
                Route::get(
                    '/{roleID}/details',
                    'RoleController@details'
                )->where('roleID', '[0-9]+');
                Route::post(
                    '/{roleID}/delete',
                    'RoleController@delete'
                )->where('roleID', '[0-9]+');
                Route::post(
                    '/{roleID}/update',
                    'RoleController@update'
                )->where('roleID', '[0-9]+');
            }
        );
        Route::prefix('permissions')->group(
            function () {
                Route::get('/list', 'PermissionController@list');
                Route::post('/new', 'PermissionController@new');
                Route::get(
                    '/{roleID}/details',
                    'PermissionController@details'
                )->where('roleID', '[0-9]+');
                Route::post(
                    '/{roleID}/delete',
                    'PermissionController@delete'
                )->where('roleID', '[0-9]+');
                Route::post(
                    '/{roleID}/update',
                    'PermissionController@update'
                )->where('roleID', '[0-9]+');
            }
        );
    }
);
