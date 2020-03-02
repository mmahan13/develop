import {erp} from '../app.js'

erp.component('tipoSwitchComponent',{
  template: `<md-switch style="margin:0 0;" class="md-primary" ng-change="$lCtrl.update()" md-no-ink aria-label="" ng-model="$lCtrl.tipoActivo"></md-switch>`, 
  bindings:{ 
    tipoActivo : '<',
    codCliente : '<'
  },
  controllerAs:'$lCtrl',
    
  controller:['$http','toastr', '$rootScope', '$scope', 
  function tipoActivoController($http, toastr, $rootScope, $scope){
     let ctrl = this;

     this.$onInit = function(){
        
      ctrl.update = function() {
         ctrl.tipo_active = ctrl.tipoActivo ? 1 : 0;
                var message = '';
                if(ctrl.tipo_active == 1){
                    message = 'Activo';
                } else {
                    message = 'Inactivo';
                }
                toastr.success('Usuario '+ctrl.codCliente+' '+ message);
      }
        
    };

       
    
  }]

});