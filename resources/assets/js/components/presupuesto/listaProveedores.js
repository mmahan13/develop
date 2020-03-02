import {erp} from '../../app.js'

erp.component('listaProveedores',{
  templateUrl: 'lista-proveedores-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','presupuestoService','FileSaver', 'moment',
   function listaClienteController($rootScope, $scope, $uibModal, $filter, toastr, presupuestoService, FileSaver, moment){
    var ctrl = this;
  
    ctrl.listarProveedores = function() 
    {

		presupuestoService.getListaProveedores().then(function success(response)
	    {
	        ctrl.listado_proveedores = response.data;
          _.each(ctrl.listado_proveedores, function (obj, i)
	        {
	           	obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
	        });
	    },
	      function error(response){
	          toastr.info('No se han cargado datos de ventas');
	          return '';
	    });

	   
    };
       
    ctrl.nuevoProveedor = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'nuevo-proveedor-modal.html',
                controller: 'nuevoProveedorModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                     	//return ctrl.lista_clientes;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        console.log(data);
                        data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                        ctrl.listado_proveedores.push(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }


     ctrl.fichaProveedor = function($event, row)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ficha-proveedor-modal.html',
                controller: 'fichaProveedorModalController',
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
  

    ctrl.listadoDePresupuestos = function($event, row)
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
                      return row;
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

    ctrl.articulosPresupuestos = function($event, row)
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
                      return row;
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
  
  
    ctrl.estadisticas_proveedor = function($event, row)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      console.log(row);
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'estadisticas-proveedor-modal.html',
                controller: 'estadisticasProveedorModalController',
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
  
     
    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_proveedores') 
      {
          ctrl.listarProveedores();
    
      }
    });
     



  }]
});
