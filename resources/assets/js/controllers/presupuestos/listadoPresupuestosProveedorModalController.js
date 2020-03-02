import {erp} from '../../app.js';

erp.controller('listadoPresupuestosProveedorModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, detalle, Upload){
    
      var ctrl = this;
      //console.log(detalle);
      ctrl.razonsocial = detalle.razonsocial;

      presupuestoService.presupuestoProveedor({codigoproveedor:detalle.codigoproveedor, codigoempresa: detalle.codigoempresa}).then(function success(response)
      {
          ctrl.lista_presupuestos_proveedor = response.data;
          _.each(ctrl.lista_presupuestos_proveedor, function (obj, i)
          {
              obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
              obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
              obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
              obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
              obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
              obj.fechapresupuesto = moment(obj.fechapresupuesto).format("DD/MM/YYYY");
          });
      },
        function error(response){
            toastr.info('No se han cargado las facturas');
            return '';
      });


   ctrl.verPresupuesto = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-presupuesto-modal.html',
                controller: 'verPresupuestoModalController',
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
                        //data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                        //ctrl.lista_clientes.unshift(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }
     

      ctrl.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
    }
]);