import {erp} from '../../app.js';

erp.controller('fichaClienteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle){
    
    var ctrl = this;
    console.log(detalle)
    ctrl.id = detalle.id;
    ctrl.codigocliente = detalle.codigocliente;
    ctrl.codigoempresa = detalle.codigoempresa;
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.cifdni = detalle.cifdni;
    ctrl.email1 = detalle.email1;
    ctrl.email2 = detalle.email2;
    ctrl.nombre1 = detalle.nombre1;
    ctrl.cargo1 = detalle.cargo1;
    ctrl.iban = detalle.iban;
    ctrl.codigobanco = detalle.codigobanco;
   
    clientes.getDomicilios({codigocliente: ctrl.codigocliente}).then(function (response){
          ctrl.domicilios = response.data;
          
    });

    
      clientes.facturasCliente({idcliente:detalle.idcliente}).then(function success(response)
      {
          ctrl.lista_facturas_cliente = response.data;
         
          ctrl.total = 0;
          _.each(ctrl.lista_facturas_cliente, function (obj, i)
          {
              obj.fechafactura = moment(obj.fechafactura).format("DD/MM/YYYY");
              ctrl.total += parseFloat(obj.importeliquido);
          });
      },
        function error(response){
            toastr.info('No se han cargado las facturas del cliente'+ctrl.razonsocial);
            return '';
      });


      ctrl.verFactura = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-factura-modal.html',
                controller: 'verFacturaModalController',
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

    ctrl.listadoDeFacturas = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'listar-facturas-cliente-modal.html',
                controller: 'listadoFacturasClienteModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                      return detalle;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
                {
                   obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                    //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
                });

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };

    ctrl.compra = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'listar-articulos-comprados-modal.html',
                controller: 'listadoArticulosCompradosModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                      return detalle;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
                {
                   obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                    //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
                });

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };

     ctrl.estadisticas = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'estadisticas-cliente-modal.html',
                controller: 'estadisticasClienteModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                      return detalle;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
                        {
                           obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                            //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
                        });

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };
      
     
      
    ctrl.guardar_cambios = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
      /*let editarCliente = {
        id: ctrl.id,
        razonsocial: ctrl.razonsocial.toUpperCase(),
        cifdni: ctrl.cifdni.toUpperCase(),
        email1: ctrl.email1,
        comentarios: ctrl.comentarios, 
        //iban: ctrl.iban.toUpperCase(),
        telefono: ctrl.telefono,
        //viapublica: ctrl.viapublica.toUpperCase(),
        domicilio: ctrl.domicilio, 
        provincia: ctrl.provincia, 
        poblacion: ctrl.poblacion,
        numero1: ctrl.numero1, 
        codigopostal: ctrl.codigopostal,
      };*/

      toastr.success('Cambios realizados');
      /*clientes.editarCliente(editarCliente).then(function (response){
          toastr.success('Cambios realizados');
          $uibModalInstance.close(response.data);
      });*/

    }

  
      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);