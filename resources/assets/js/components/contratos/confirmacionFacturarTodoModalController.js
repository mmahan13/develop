import {erp} from '../../app.js';

erp.controller('confirmacionFacturarTodoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    
    ctrl.pendientes_facturacion = detalle;
    ctrl.numero = parseInt(ctrl.pendientes_facturacion.length);


    ctrl.confirmar = function () {
        $uibModalInstance.close(ctrl.pendientes_facturacion);
    };  
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);
