import {erp} from '../../app.js';

erp.controller('verTrimestreTotalModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','facturaService','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, facturaService, FileSaver){
    
    var ctrl = this;
    
    facturaService.verTrimestreTotal().then(function (response){
          ctrl.trimestre_total_facturas = response.data;
          
    });
    
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);

                                                                                                                                                                                                                                            