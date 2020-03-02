import {erp} from '../../app.js';

erp.controller('nuevaEmpresaModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','empresas', 'detalle',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, empresas, detalle){
    
    var ctrl = this;
      
    ctrl.nueva_empresa = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
      let newEmpresa = {
        empresa: ctrl.empresa.toUpperCase(),
        cifdni: ctrl.cifdni.toUpperCase(),
        iban: ctrl.sigla.toUpperCase()+''+ctrl.iban+''+ctrl.entidad,
        
      };
      console.log(newEmpresa);

      toastr.success('Creada correctamente');
      $uibModalInstance.close(newEmpresa);
     /* empresas.nuevoEmpresa(newEmpresa).then(function (response){
          toastr.success('Creada correctamente');
          
      });*/

    };

  


      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);