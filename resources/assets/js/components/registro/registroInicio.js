import {erp} from '../../app.js'

erp.component('registroInicio',{
templateUrl: 'registro-inicio.html',

controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','usuariosService','FileSaver', 'moment', 
   function registroInicio($rootScope, $scope, $uibModal, $filter, toastr, usuariosService, FileSaver, moment,){
    var ctrl = this;
  
    ctrl.guardarDatos = function($event) 
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
        
        ctrl.data = {
            name:  ctrl.razonsocial,
            apellidos: ctrl.apellidos,
            dni: ctrl.dni,
            telefono: ctrl.telefono,
            email: ctrl.email,
            password: ctrl.password,
            direccion: ctrl.direccion
        }
    
        usuariosService.newUser(ctrl.data).then(
        function(response)
        {
            console.log(response);
            toastr.success('Registrado correctamente');
            ctrl.razonsocial = '';
            ctrl.apellidos = '';
            ctrl.dni = '';
            ctrl.telefono = '';
            ctrl.email = '';
            ctrl.password = '';
            ctrl.direccion = '';
        },function error(response){
            toastr.info('No se ha podido registrar');
        });
    }
        

        
 
    

    
   
  }]
});
