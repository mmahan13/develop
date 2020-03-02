import {erp} from '../../app.js';

erp.controller('verTrimestreTotalPresupuestoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, FileSaver){
    
    var ctrl = this;
    
    presupuestoService.presupuestosTotalTrimestre().then(function (response){
          ctrl.trimestre_total_presupuestos = response.data;
          console.log(ctrl.trimestre_total_presupuestos);
          
    });
    
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);