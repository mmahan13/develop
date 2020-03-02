import {erp} from '../../app.js';

erp.controller('leerMasModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','facturaService', 'detalle','FileSaver','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, facturaService, detalle, FileSaver, contratosService){
    
    var ctrl = this;
    ctrl.descripcionlinea = detalle;
  
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);