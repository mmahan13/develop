import {erp} from '../../app.js';

erp.controller('detalleAFacturarModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    ctrl.importenetolineas = detalle.importenetolineas;
    ctrl.importedescuento = detalle.importedescuento | 0;
    ctrl.pordescuento = detalle.pordescuento | 0;
    ctrl.baseimponible = detalle.baseimponible;
    contratosService.detallePlan({idplan:detalle.idplan}).then(function success(response)
	{
	   ctrl.detalle_a_facturar = response.data;
    },function error(response){
	          toastr.info('No se han cargado los contratos');
	          return '';
	    });

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);