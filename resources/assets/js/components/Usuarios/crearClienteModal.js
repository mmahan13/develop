import {erp} from '../../app.js';

erp.controller('crearClineteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','usuariosService','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, usuariosService, FileSaver){
    
    var ctrl = this;
    
    ctrl.crearCliente = function() 
    {
      ctrl.data = {
        id: ctrl.id,
        nombre: ctrl.nombre,
        apellidos: ctrl.apellidos,
        email: ctrl.email,
        telefono: ctrl.telefono,
        dni: ctrl.dni,
        direccion: ctrl.direccion
      };
      usuariosService.crearUsuario(ctrl.data).then(function success(response)
      { 
        $uibModalInstance.close(response.data);
        if(response.status === 200)
        toastr.success('Nuevo cliente creado');
      },function error(response){
        toastr.info('Error al crear el cliente');
      });
    };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);