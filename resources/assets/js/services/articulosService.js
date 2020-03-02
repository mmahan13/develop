import {erp} from '../app.js';
erp.service('articulos', ['$http', function ($http) {
   
    this.getArticulos = function () {
        return $http.get('get/productos');
    };

    this.getIvas = function () {
        return $http.get('/get/ivas');
    };

    this.nuevoProducto = function (data) {
    	if(angular.isObject(data)){
        	return $http.post('/crear/producto', data);
    	}
    };

    this.editarArticulo = function (data) {
    	if(angular.isObject(data)){
        	return $http.post('/editar/producto', data);
    	}
    };

    this.delete = function (id) {
        return $http.get('/delete/producto/'+id);
    };


   /* this.getArticulosObsoletoNo = function () {
        return $http.post('/lista/articulos/obsoleto/no');
    };

     this.getArticulosSegunTarifaPrecio = function (data) {
        if(angular.isObject(data)){
            return $http.post('/lista/articulos/segun/tarifa',data);
        }
    };

    this.tiposIva = function () {
        return $http.post('/tipos/ivas');
    };

    this.familias = function () {
        return $http.post('/familia/articulos');
    };

    this.updateTipoIva = function (data) {
    	if(angular.isObject(data)){
        	return $http.post('/update/iva/articulo', data);
    	}
    };

    this.updateObsoleto = function (data) {
    	if(angular.isObject(data)){
        	return $http.post('/update/obsoleto', data);
    	}
    };

    

    */




}]);