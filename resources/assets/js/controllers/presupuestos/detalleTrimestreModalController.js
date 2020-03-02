import {erp} from '../../app.js';

erp.controller('detalleTrimestreModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, detalle, Upload){
    
    var ctrl = this;
    ctrl.trimestre = detalle.trimestre;
    
	presupuestoService.presupuestosPorTrimestre({codigoproveedor:detalle.codigoproveedor, trimestre: detalle.trimestre, codigoempresa: detalle.codigoempresa}).then(function success(response)
	{
	    ctrl.presupuestos_por_trimestes = response.data;
	    //console.log(ctrl.presupuestos_por_trimestes);
	   _.each(ctrl.presupuestos_por_trimestes, function (obj, i)
	      {
	          obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
	          obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
	          obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
	          obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
	          obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
	        
	      });

	},function error(response){
	        toastr.info('No se han cargado los presupuestos');
	        return '';
	});


  
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);