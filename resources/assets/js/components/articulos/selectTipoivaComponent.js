import {erp} from '../../app.js'

erp.component('selectTipoivaComponent',{
  template: `<select class="form-control" name="tipoiva"  ng-change="updateIva()" ng-options="option.tipoiva for option in $lCtrl.Tipos track by option.idiva" 
ng-model="$lCtrl.ivas.tipo"></select>`, 

 bindings:{ 
    grupoIva : '<',
    codArticulo : '<',
    idArticulo : '<', 
             
           },
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','articulos','FileSaver', 'moment', 
   function selectTipoivaController($rootScope, $scope, $uibModal, $filter, toastr, articulos, FileSaver, moment,){
    var ctrl = this;
  
     this.$onInit = function(){
        
          ctrl.ivas = {};
          articulos.tiposIva().then(function (response)
          {
              ctrl.Tipos = response.data;
              _.each(ctrl.Tipos, function (obj, i)
              {
                obj.idiva = parseInt(obj.idiva);
                if(parseInt(ctrl.grupoIva) == obj.idiva)
                {
                  ctrl.ivas.tipo = obj;
                }
              });
          });

        
 
    };

    /*this.$onChanges = function(cambio){
      if(ctrl.Tipos && ctrl.pvpPn && cambio && cambio.pvpPn && cambio.pvpPn.currentValue)
      {
        ctrl.tarifa.tipo = ctrl.Tipos[ctrl.pvpPn];
      }
    };*/
   
  }]
});
