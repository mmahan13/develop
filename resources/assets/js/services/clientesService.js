import {erp} from '../app.js';
erp.service('clientes', ['$http', function ($http) {
   
    this.getListaClientes = function () {
        return $http.post('/lista/clientes');
    };

      this.getDomicilios = function (data) {
        if(angular.isObject(data)){
            return $http.post('/get/domicilios/cliente', data);
        }
    };

    this.nuevoCliente = function (data) {
        if(angular.isObject(data)){
            return $http.post('/nuevo/cliente', data);
        }
    };

    this.editarCliente = function (data) {
        if(angular.isObject(data)){
            return $http.post('/editar/cliente', data);
        }
    };

     //sigla
    this.codigosPostales = function () {
        return $http.post('/codigos/postales');
    };

    //provincia
    this.getProvincia = function () {
        return $http.post('/provincia');
    };

    //poblacion
    this.getPoblacion = function (data){
    	if(angular.isObject(data)){
        	return $http.post('/poblacion', data);
        }
    };

    //cp
    this.getCodigoPostal = function (data){
    	if(angular.isObject(data)){
        	return $http.post('/cp', data);
        }
    };

    this.facturasCliente = function (data){
        if(angular.isObject(data)){
            return $http.post('/lista/facturas/cliente', data);
        }
    };

    this.informeAnual = function (data){
        if(angular.isObject(data)){
            return $http.post('/informe/anual/facturas', data);
        }
    };
    
    this.informeTrimestral = function (data){
        if(angular.isObject(data)){
            return $http.post('/infrome/trimestral/facturas', data);
        }
    };

     this.comprasCliente = function (data) {
        if(angular.isObject(data)){
            return $http.post('/compras/cliente', data);
        }
    };
}]);