import {erp} from '../../app.js';

erp.controller('editarClineteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','usuariosService','detalle','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, usuariosService,detalle, FileSaver){
    
    var ctrl = this;
    
    ctrl.modaltitle ='Editar cliente';
    ctrl.id = detalle.id;
    ctrl.nombre = detalle.nombre;
    ctrl.apellidos = detalle.apellidos;
    ctrl.email = detalle.email;
    ctrl.telefono = detalle.telefono;
    ctrl.dni = detalle.dni;
    ctrl.direccion = detalle.direccion;
    
    ctrl.guardarCambios = function() 
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
      usuariosService.guardarCambiosUsuario(ctrl.data).then(function success(response)
      { 
        if(response.status === 200)
        $uibModalInstance.close(response.data);
        toastr.success('Datos actualizados correctamente');
      },function error(response){
        toastr.info('Error al actualizar los datos');
      });
    };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);