import {erp} from '../app.js';
erp.service('facturaService', ['$http','FileSaver', '$rootScope', function ($http, FileSaver, $rootScope) {
   
    this.facturar = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/guardar/factura', data);
        }
    };

    this.numeroFactura = function (){
       return $http.get('/numero/factura');
    };

    this.getListaFacturas = function(){
    	return $http.get('/get/lista/facturas')
    }

    
    this.getLineasFactura = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/get/lineas/factura', data);
        }
    };

    this.totalesIvas = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/totales/ivas/factura/cliente', data);
        }
    };

    this.facturasPorTrimestre = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/lista/facturas/trimestre', data);
        }
    };

    this.verTrimestreTotal = function () 
    {
       return $http.post('/lista/facturas/total/trimestre');
    };

    this.datosFinancieros = function(data)
    {
        if(angular.isObject(data))
        {
            return $http.post('/get/datos/financieros', data);
        }
    }

    this.getListaLotesFacturas = function()
    {
       return $http.post('/lista/lotes/factura/cliente');
    }

    this.tipoFactura = function()
    {
        return $http.get('/tipo/factura');
    }

    /*this.crearPDF = function(data)
    {
        if(angular.isObject(data))
        {
            return $http.post('/crear/pdf', data);
        }
    }*/

    this.crearPDF = function (data) 
    {
        console.log(data);
        if(angular.isObject(data))
        {
                var numerofactura = data.facturacabecera.numerofactura;
                return $http({
                    method: 'post',
                    url: '/crear/pdf',
                    data: data,
                    responseType: 'arraybuffer' }).then(function (response){
                
                var file = new Blob([response.data], {type: 'application/pdf'});
                if(file.type == 'application/pdf')
                {
                    $rootScope.$emit('descargaOK', {ok:1});
                }
                FileSaver.saveAs(file, 'factura-'+ numerofactura +'.pdf');
            },
        
            function error(response){
            return '';
            });
        }
    };

    
}]);