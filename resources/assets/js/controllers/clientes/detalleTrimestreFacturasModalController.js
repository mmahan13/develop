import {erp} from '../../app.js';

erp.controller('detalleTrimestreFacturasModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','facturaService', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, facturaService, detalle, Upload){
    
    var ctrl = this;
    
    ctrl.trimestre = detalle.trimestre;
    
	facturaService.facturasPorTrimestre({codigocliente:detalle.codigocliente, trimestre: detalle.trimestre, codigoempresa: detalle.codigoempresa}).then(function success(response)
	{
	    ctrl.facturas_por_trimestes = response.data;
	    ctrl.total = 0;
	    _.each(ctrl.facturas_por_trimestes, function (obj, i)
	    {
	        obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
	        obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
	        obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
	        obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
	        obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
	        obj.fechaalbaran = moment(obj.fechaalbaran).format("DD/MM/YYYY");
	    	ctrl.total += parseFloat(obj.importeliquido)
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