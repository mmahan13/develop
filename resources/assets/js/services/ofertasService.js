import {erp} from '../app.js';
erp.service('ofertasService', ['$http','FileSaver', '$rootScope', function ($http, FileSaver, $rootScope) {
   
    this.generarOferta = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/guardar/oferta', data);
        }
    };

    this.numeroOferta = function (){
       return $http.post('/numero/oferta');
    };

    this.getOfertasCliente = function(){
    	return $http.post('/get/ofertas/cliente')
    }

    
    this.getLineasOferta = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('/get/lineas/ofertas', data);
        }
    };

    this.totalesIvas = function (data) 
    {
        if(angular.isObject(data)){
            return $http.post('totales/ivas/ofertas', data);
        }
    };

  


    this.getListaLotesFacturas = function()
    {
       return $http.post('/lista/lotes/factura/cliente');
    }

    this.tipoOferta = function()
    {
        return $http.get('/tipo/oferta');
    }

    this.crearPDF = function (data) 
    {
        if(angular.isObject(data)){
            var numerofactura = data.facturacabecera.numerofactura;
            var fechafactura = data.facturacabecera.fechafactura;
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
            FileSaver.saveAs(file, 'factura_'+ numerofactura +'_'+ fechafactura +'.pdf');
        },
        function error(response) {
           return '';
        });
        }
    };

    
}]);