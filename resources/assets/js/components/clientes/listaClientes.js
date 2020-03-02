import {erp} from '../../app.js'

erp.component('listaClientes',{
  templateUrl: 'lista-clientes-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','clientes','FileSaver', 'moment','uiGridConstants','i18nService',
   function listaClienteController($rootScope, $scope, $uibModal, $filter, toastr, clientes, FileSaver, moment,uiGridConstants,i18nService){
    var ctrl = this;
  
    ctrl.listarClientes = function() 
    {

		clientes.getListaClientes().then(function success(response)
	    {
	      ctrl.lista_clientes = response.data;
        _.each(response.data, function (obj, i)
        {
            obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
        });
          //console.log(ctrl.lista_clientes)
          ctrl.tableOpts.data = []; 
          ctrl.tableOpts.data = ctrl.lista_clientes;
          ctrl.tableOpts.columnDefs = ctrl.colDef;
        
	    },
	      function error(response){
	          toastr.info('No se han cargado datos de ventas');
	          return '';
	    }).finally(() => {
                setTimeout(() => { // para arreglar el ancho de la tabla y que se ocultan columnas
                    $(window).resize();
                    ctrl.gridApi.core.refresh();
                }, 500)
            });

	   
    };

      ctrl.initTable = function ()
      {
            i18nService.setCurrentLang('es');
            ctrl.uiGridConstants = uiGridConstants;
              

                ctrl.colDef = [
                    
                    {
                        displayName: 'Razon Social',
                        field: 'razonsocial',
                        name: 'razonsocial',
                        width: '*',
                        minWidth: 100,
                        type: 'string',
                       
                        enableCellEdit: false,
                    },
                    {
                        displayName: 'CIF',
                        field: 'cifdni',
                        name: 'cifdni',
                        width: '10%',
                        minWidth: 50,
                        enableCellEdit: false,
                        cellClass: 'text-left',
                       
                    },
                    {
                        displayName: 'E-mail',
                        field: 'email1',
                        name: 'email1',
                        width: '20%',
                        minWidth: 50,
                        //cellTemplate: `<button ng-click="grid.appScope.$ctrl.changeParte($event,row.entity)"><i class="fa fa-lg fa-fw" ng-class="{'fa-unlock': row.entity.estado_parte === 'A', 'fa-lock': row.entity.estado_parte === 'F' || row.entity.estado_parte === 'C', 'fa-unlock-alt': row.entity.estado_parte === 'R'}" aria-hidden="true"></i></button>`,
                        type: 'string',
                 
                        cellClass: 'text-left',
                        
                    },
                    {
                        displayName: 'Responsable',
                        field: 'nombre1',
                        name: 'nombre1',
                        width: '20%',
                        minWidth: 50,
                         cellClass: 'text-left',
                        //cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD.slice(-3) %}</div>`,
                       /* filter: {
                            condition: function (searchTerm, cellValue) {
                                return ctrl.multiElementMatch(searchTerm, cellValue);
                            }
                        },*/
                    },
                    {
                        displayName: 'Fecha Alta',
                        field: 'fechaalta',
                        name: 'fechaalta',
                        width: '10%',
                        minWidth: 50,
                        type: 'number',
                        cellClass: 'text-left',
                        //cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                        
                        /*filter: {
                            condition: function (searchTerm, cellValue) {
                                return ctrl.multiElementMatch(searchTerm, cellValue);
                            }
                        },*/
                    },
                    
                ];
                
                ctrl.tableOpts = {
                    columnDefs: ctrl.colDef,
                    enableGridMenu: true,
                    enableSorting: true,
                    fastWatch: true,
                    enableSelectAll: true,
                    showGridFooter: true,
                    showColumnFooter: true,
                    enableFiltering: true,
                      rowTemplate: `
                    <div
                        ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid"
                        ui-grid-one-bind-id-grid="rowRenderIndex + '-' + col.uid + '-cell'"
                        class="ui-grid-cell"
                        ng-click="grid.appScope.$lCtrl.fichaCliente(row.entity)"
                        ng-class="{ 'ui-grid-row-header-cell': col.isRowHeader }"
                        role="{{col.isRowHeader ? 'rowheader' : 'gridcell'}}"
                        ui-grid-cell style="cursor: pointer;">
                    </div>`,

                    onRegisterApi: function (gridApi) {
                    ctrl.gridApi = gridApi;
                    gridApi.core.on.columnVisibilityChanged(null, function (changedColumn) {
                        ctrl.columnChanged = {
                            name: changedColumn.colDef.name,
                            visible: changedColumn.colDef.visible
                        };
                    });
                }

                };
            };
       
    ctrl.nuevoCliente = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'nuevo-cliente-modal.html',
                controller: 'nuevoClienteModalController',
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
                        ctrl.lista_clientes.unshift(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.fichaCliente = function(row)
    {
      //$event.stopImmediatePropagation();
      //$event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ficha-cliente-modal.html',
                controller: 'fichaClienteModalController',
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


    ctrl.listadoDeFacturas = function($event, row)
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
                      return row;
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

    ctrl.compra = function($event, row)
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
                      return row;
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
  
    ctrl.estadisticas = function($event, row)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      console.log(row);
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
                      return row;
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
  
    ctrl.initTable();
    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'lista_clientes') 
      {
          ctrl.listarClientes();
    
      }
    });
     



  }]
});
