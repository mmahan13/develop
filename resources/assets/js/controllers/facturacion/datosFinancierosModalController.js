import {erp} from '../../app.js';

erp.controller('datosFinancierosModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','FileSaver','detalle','facturaService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, FileSaver, detalle, facturaService){
    
    var ctrl = this;
    console.log(detalle);

    facturaService.datosFinancieros({idalbaran:detalle}).then(function success(response)
    {
        ctrl.datos_financieros = response.data;
        console.log(ctrl.datos_financieros)
            

    },function error(response){
                    toastr.info('No se han cargado los datos financieros');
                    return '';
            });

    ctrl.cancel = function ()
    {
    	$uibModalInstance.close(detalle);
    };
  }
]);