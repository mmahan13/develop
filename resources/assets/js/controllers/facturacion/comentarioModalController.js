import {erp} from '../../app.js';

erp.controller('comentarioModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','FileSaver','detalle',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, FileSaver, detalle){
    
    var ctrl = this;
    ctrl.descripcionlinea = detalle.descripcionlinea;
    
    ctrl.cancel = function ()
    {
    	detalle.descripcionlinea = ctrl.descripcionlinea;
		$uibModalInstance.close(detalle);
    };
  }
]);