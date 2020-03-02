import {erp} from '../../app.js'

erp.component('listadoGastosProveedores',{
  templateUrl: 'listado-gastos.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','presupuestoService','FileSaver', 'moment',
   function listadoPresupuestosController($rootScope, $scope, $uibModal, $filter, toastr, presupuestoService, FileSaver, moment){
    var ctrl = this;
  
    ctrl.listarGastoProveedores = function() 
    {

  		presupuestoService.listarGastosProveedor().then(function success(response)
      {
        ctrl.lista_gastos = response.data;
        _.each(ctrl.lista_gastos, function (obj, i)
        {
            obj.fechafactura = moment(obj.fechafactura).format("DD/MM/YYYY");
        });
      },
        function error(response){
            toastr.info('No se han encontrado gastos de proveedor');
            return '';
      });
    };


    ctrl.verGasto = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-gasto-modal.html',
                controller: 'verGastoModalController',
                controllerAs: '$ctrl',
                size: 'xs',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                     	return row;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        //let data = response;
                        //data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                        //ctrl.lista_clientes.unshift(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }
   
    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_gastos_proveedores') 
      {
          ctrl.listarGastoProveedores();
    
      }
    });

  }]
});
