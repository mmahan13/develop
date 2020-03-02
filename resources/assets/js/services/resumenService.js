import {erp} from '../app.js';
erp.service('resumenService', ['$http','FileSaver', '$rootScope', function ($http, FileSaver, $rootScope) {
   
    this.emitidas = function () 
    {
        return $http.post('/resumen/emitidas');
    };

     this.recibidas = function () 
    {
        return $http.post('/resumen/recibidas');
    };


    
}]);