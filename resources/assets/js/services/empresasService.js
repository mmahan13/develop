import {erp} from '../app.js';
erp.service('empresas', ['$http', function ($http) {
   
    this.getListaEmpresas = function () {
        return $http.post('/lista/empresas');
    };

   
  
}]);