import {erp} from '../../app.js';

erp.controller('verGastoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService', 'detalle','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, detalle, FileSaver){
    
    var ctrl = this;
    
    ctrl.fechafactura = detalle.fechafactura;
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.cifdni = detalle.cifdni;
    ctrl.codigoarticulo = `G-${detalle.numerogasto}`;
    ctrl.descripcionfactura = detalle.descripcionfactura;
    ctrl.precio = detalle.baseimponibleexento;
   
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);