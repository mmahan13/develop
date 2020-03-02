import {erp} from '../../app.js';

erp.controller('fichaProveedorModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle){
    
    var ctrl = this;

    ctrl.id = detalle.id;
    ctrl.codigocliente = detalle.codigocliente;
    ctrl.codigoempresa = detalle.codigoempresa;
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.cifdni = detalle.cifdni;
    ctrl.email1 = detalle.email1;
    ctrl.iban = detalle.iban;
    ctrl.comentarios = detalle.comentarios;
    ctrl.logoempresa = detalle.logoempresa;

    clientes.getDomicilios({codigocliente: ctrl.codigocliente}).then(function (response){
          ctrl.domicilios = response.data;
          //console.log(ctrl.domicilios);
    });
      
     
    ctrl.listadoDePresupuestos = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'listar-presupuestos-proveedor-modal.html',
                controller: 'listadoPresupuestosProveedorModalController',
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
                       /* let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
                        {
                           obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                            //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
                        });*/

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };

     ctrl.articulosPresupuestos = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'lista-articulos-proveedor-modal.html',
                controller: 'articulosProveedorModalController',
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
                        /*let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
                        {
                           obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                            //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
                        });*/

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };
      
    /*ctrl.guardar_cambios = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
      let editarCliente = {
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
      };

      toastr.success('Cambios realizados');
      

    }*/

  
      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);