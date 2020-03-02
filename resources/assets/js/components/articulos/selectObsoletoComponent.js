import {erp} from '../../app.js'

erp.component('selectObsoletoComponent',{
  template: `<select class="form-control" name="tipoiva"  ng-change="updateObsoleto()" ng-options="option.tipo for option in $lCtrl.Tipos track by option.id" 
ng-model="$lCtrl.obsoleto.tipo"></select>`, 

 bindings:{ 
    artiObsoleto : '<',
    codArticulo : '<',
    idArticulo : '<', 
             
           },
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','articulos','FileSaver', 'moment', 
   function selectObsoletoController($rootScope, $scope, $uibModal, $filter, toastr, articulos, FileSaver, moment,){
    var ctrl = this;
  
     this.$onInit = function(){
        
        ctrl.obsoleto = {};
        ctrl.Tipos = [
          {id:0, tipo:'No', value: 0},
          {id:1, tipo:'Si', value: 1},
        ]
        
        ctrl.obsoleto.tipo = ctrl.Tipos[ctrl.artiObsoleto];

        
        $scope.updateObsoleto = function() {
        
          let data = {
            idarticulo: ctrl.idArticulo,
            obsoleto: ctrl.obsoleto.tipo.value,
          };
            console.log(data);
          articulos.updateObsoleto(data).then(function (response){
              if (response.status === 200) 
              toastr.success('Obsoleto '+ ctrl.obsoleto.tipo.tipo);
              
          });
        }
    };
   
  }]
});
