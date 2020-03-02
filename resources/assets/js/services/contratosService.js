import {erp} from '../app.js';
erp.service('contratosService', ['$http','FileSaver', '$rootScope', function ($http, FileSaver, $rootScope) {
   
    this.contratos = function () 
    {
        return $http.post('/get/contratos');
    };

    this.getContrato = function (data) 
    {
        return $http.post('/get/contrato',data);
    };

    this.lineas = function(data) 
    {
    	if(angular.isObject(data)){
        	return $http.post('/get/lineas/contrato', data);
    	}
    };

     this.aniadirLinea = function(data) 
    {
        if(angular.isObject(data)){
            return $http.post('/aniadir/linea/contrato', data);
        }
    };

    this.planContrato = function(data)
    {
    	if(angular.isObject(data)){
        	return $http.post('/get/plan/contrato', data);
    	}
    };

    this.detallePlan = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/get/detalle/plan', data);
        }
    };
    this.activar = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/activar/contrato', data);
        }
    };
   

    this.renueva = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/renueva/contrato', data);
        }
    };

    this.nuevoContrato = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/nuevo/contrato', data);
        }
    };

    this.guardarEdicion = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/edita/linea/contrato', data);
        }
    };
    
    this.guardarEdicionCabecera = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/edita/cabecera/contrato', data);
        }
    };

    this.actiDesactiArticulo = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/activar/desactivar/linea/articulo', data);
        }
    };

    this.actualizarFechalineaContrato = function(data)
    {
        if(angular.isObject(data)){
            return $http.post('/cambiar/fecha/linea/contrato', data);
        }
    };

    this.getPendientesFacturacion = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/get/pendientes/facturacion', data);
        }
    };

    this.creaFacturaDesdeContrato = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/crea/factura/desde/contrato', data);
        }
    };

    this.facturarTodasDesdeContrato = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/facturar/todas/desde/contrato', data);
        }
    };

    this.cambiarFechaActivacionCabeceraContrato = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/add/fecha/activacion/contrato', data);
        }
    };

     this.cambiarFechaActivacionLineaContrato = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/cambiar/fecha/activacion/linea/contrato', data);
        }
    };

    this.tienePlanFacturado = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/contrato/tiene/plan/facturado', data);
        }
    };
}]);