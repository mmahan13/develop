import {erp} from '../app.js';
erp.service('usuariosService', ['$http','FileSaver','$rootScope', function ($http, FileSaver, $rootScope) {
    
    this.listarUsuarios = function () {
        return $http.get('/listado/usuarios');
    };

    this.guardarCambiosUsuario = function (data) {
        if(angular.isObject(data)){
            return $http.post('/editar/cliente', data);
        }
    };

    this.crearUsuario = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/crear/cliente', data);
        }
    };

    this.delete = function (id) {
        return $http.get('/delete/cliente/'+id);
    };

    /****************************************/
    this.getProductos = function () {
        return $http.get('/get/productos');
    };

    
    this.newUser = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/new/user', data);
        }
    };

    /*this.getCabeceraIvas = function () {
        return $http.post('/get/cabevera/ivas');
    };

    this.getNumeroPresupuesto = function (){
       return $http.post('/numero/presupuesto');
    };

   

    this.crearNuevoCliente = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/guardar/factura/con/articulos', data);
        }
    };

    this.guardarCabeceraFactura = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/proveedor/guardar/cabecera/factura', data);
        }
    };

    this.listarFacturasProveedor = function () 
    {
        return $http.post('/listar/factura/proveedor');
    };

    this.listarGastosProveedor = function () 
    {
        return $http.post('/listar/gastos/proveedor');
    };

     this.presupuestoProveedor = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/lista/proveedor/presupuesto', data);
        }
    };
    
    this.getLineasFacturaProveedor = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/lineas/factura/proveedor', data);
        }
    };

    this.totalesIvasFacturaProveedores = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/totales/ivas/factura/proveedores', data);
        }
    };


    this.informeAnual = function (data){
        if(angular.isObject(data)){
            return $http.post('/informe/anual/presupuestos', data);
        }
    };
    
    this.informeTrimestral = function (data){
        if(angular.isObject(data)){
            return $http.post('/infrome/trimestral/presupuestos', data);
        }
    };

    this.presupuestosPorTrimestre = function (data){
        if(angular.isObject(data)){
            return $http.post('/lista/presupuestos/trimestre', data);
        }
    };

    this.presupuestosTotalTrimestre = function ()
    {
        return $http.post('/lista/presupuestos/total/trimestre');
    }



    this.crearPDFFacturaProveedor = function (data) 
    {
       
        if(angular.isObject(data)){
        
            var numerofactura = data.presupuestocabecera.numerofactura;
            var fechafactura = data.presupuestocabecera.fechafactura;
            return $http({
                method: 'post',
                url: '/crear/pdf/factura/proveedor',
                data: data,
                responseType: 'arraybuffer' }).then(function (response){
                
            var file = new Blob([response.data], {type: 'application/pdf'});
            if(file.type == 'application/pdf')
            {
                $rootScope.$emit('descargaOK', {ok:1});
            }
            FileSaver.saveAs(file, 'factura_'+ numerofactura +'_'+ fechafactura +'.pdf');
        },
        function error(response) {
           return '';
        });
        }
    };

    this.articulosProveedor = function (data) {
        if(angular.isObject(data)){
            return $http.post('/articulos/proveedor', data);
        }
    };*/
   
}]);