import {erp} from '../../app.js'

erp.component('pendientesFacturacion',{
  templateUrl: 'pendientes-facturacion-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','contratosService','FileSaver', 'moment','exportXlsx',
   function contratosController($rootScope, $scope, $uibModal, $filter, toastr, contratosService, FileSaver, moment, exportXlsx){
    
    var ctrl = this;
    ctrl.dato_generico = {fechainicio: 0 };

    ctrl.fechai = moment(new Date()).format('DD/MM/YYYY');

    var hoy = new Date();
    var devolucion = new Date();
    devolucion.setDate(hoy.getDate() + 31);
    ctrl.fechaf = moment(devolucion).format('DD/MM/YYYY');

    $rootScope.$on('fechai', function(event, data){
        ctrl.fechai = moment(data.fecha).format('DD/MM/YYYY');
    });
    $rootScope.$on('fechaf', function(event, data){
        ctrl.fechaf = moment(data.fecha).format('DD/MM/YYYY');
    });

     ctrl.total_a_facturar = 0;
    ctrl.datosFactura = function(){
      ctrl.total_a_facturar = 0;
      /*contratosService.getPendientesFacturacion({fechai:ctrl.fechai, fechaf:ctrl.fechaf}).then(function success(response)
      {
        ctrl.pendientes_facturacion = response.data;
        _.each(ctrl.pendientes_facturacion, function (obj, i)
        {
          obj.fecha = moment(obj.fecha).format('DD/MM/YYYY');
          ctrl.total_a_facturar += parseFloat(obj.baseimponible);
        });
      },function error(response){
          toastr.info('No hay lista de pendientes');
          return '';
      });*/
    }

    $scope.$watch("$lCtrl.fechai", function(newValue, oldValue){
        ctrl.datosFactura(newValue, ctrl.fechaf);
    });
    $scope.$watch("$lCtrl.fechaf", function(newValue, oldValue){
        ctrl.datosFactura(ctrl.fechai, newValue);

    });

    ctrl.detalleFacturar = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'detalle-a-facturar-modal.html',
                controller: 'detalleAFacturarModalController',
                controllerAs: '$ctrl',
                size: 'lg',
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
                        //console.log(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.facturarTodo = function($event, fechai, fechaf)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'conformacion-facturar-todo-modal.html',
                controller: 'confirmacionFacturarTodoModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                      return ctrl.pendientes_facturacion;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        if(angular.isObject(data))
                        {
                          contratosService.facturarTodasDesdeContrato({fechai:fechai, fechaf:fechaf}).then(function success(response)
                          {
                            let idplan = response.data;
                            //console.log(idplan)
                            if(angular.isDefined(idplan))
                            {
                              ctrl.datosFactura(ctrl.fechai, ctrl.fechaf);
                              data.length == 1 ? toastr.success('Contrato facturado correctamente'): toastr.success('Los '+ data.length +' contratos se han facturado correctamente');
                              
                            }
                            
                            
                          },function error(response){
                              toastr.info('No se ha podido facturar este contrato');
                              return '';
                          });
                        }
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.facturar = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
        contratosService.creaFacturaDesdeContrato({idplan:row.idplan}).then(function success(response)
        {
          let idplan = response.data;
          //console.log(idplan);
          if(angular.isDefined(idplan)){
            ctrl.datosFactura(ctrl.fechai, ctrl.fechaf);
            toastr.success('Facturado correctamente');
         }
          
          
        },function error(response){
            toastr.info('No se ha podido facturar este contrato');
            return '';
        });
    }
  

  }]
});
