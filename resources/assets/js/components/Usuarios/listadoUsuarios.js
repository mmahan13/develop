import {erp} from '../../app.js'

erp.component('listadoUsuarios',{
  templateUrl: 'tabla_listado_usuarios.html',
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','usuariosService','FileSaver', 'moment','$mdDialog','uiGridConstants','i18nService',
   function listadoUsuariosController($rootScope, $scope, $uibModal, $filter, toastr, usuariosService, FileSaver, moment, $mdDialog, uiGridConstants, i18nService){
    var ctrl = this;
    ctrl.tableOpts = {};

    ctrl.listarUsuarios = function() 
    {
      usuariosService.listarUsuarios().then(function success(response)
      { 
        ctrl.tableOpts.data = []; 
        ctrl.tableOpts.data = response.data;
        ctrl.tableOpts.columnDefs = ctrl.colDef;
      },
        function error(response){
            toastr.info('Error al cargar los clientes');
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
                    displayName: 'Nombre',
                    field: 'nombre',
                    name: 'nombre',
                    width: '15%',
                    minWidth: 100,
                    type: 'number',
                    cellClass: 'text-left',
                },
                {
                  displayName: 'Apellidos',
                  field: 'apellidos',
                  name: 'apellidos',
                  width: '20%',
                  minWidth: 100,
                  type: 'number',
                  cellClass: 'text-left',
              },
                {
                    displayName: 'DNI',
                    field: 'dni',
                    name: 'dni',
                    width: '10%',
                    minWidth: 100,
                    enableCellEdit: false,
                    cellClass: 'text-left',
                },
                {
                    displayName: 'Email',
                    field: 'email',
                    name: 'email',
                    width: '20%',
                    minWidth: 100,
                    //cellTemplate: `<button ng-click="grid.appScope.$ctrl.changeParte($event,row.entity)"><i class="fa fa-lg fa-fw" ng-class="{'fa-unlock': row.entity.estado_parte === 'A', 'fa-lock': row.entity.estado_parte === 'F' || row.entity.estado_parte === 'C', 'fa-unlock-alt': row.entity.estado_parte === 'R'}" aria-hidden="true"></i></button>`,
                    type: 'string',
                    cellClass: 'text-left',
                },
                {
                    displayName: 'Teléfono',
                    field: 'telefono',
                    name: 'telefono',
                    width: '10%',
                    minWidth: 100,
                    cellClass: 'text-right',
                    //cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD.slice(-3) %}</div>`,
                   /* filter: {
                        condition: function (searchTerm, cellValue) {
                            return ctrl.multiElementMatch(searchTerm, cellValue);
                        }
                    },*/
                },
                {
                  displayName: 'Dirección',
                  field: 'direccion',
                  name: 'direccion',
                  width: '20%',
                  minWidth: 100,
                  cellClass: 'text-left',
              },
              {
                displayName: '',
                field: 'id',
                name: 'id',
                width: '5%',
                minWidth: 100,
                cellClass: 'text-center',
                cellTemplate: `
                              <div class="ui-grid-cell-contents">
                                <i style="font-size: 18px;" class="fa fa-list-alt" aria-hidden="true" ng-click="grid.appScope.$lCtrl.listadoFacturas($event,row.entity.id)"></i>
                                <i style="font-size: 18px;" ng-click="grid.appScope.$lCtrl.deleteCliente($event,row.entity.id)" class="fa fa-trash-o" aria-hidden="true"></i>
                              </div>  
                          `,
               
              },
              
                
            ];
            
            ctrl.tableOpts = {
                columnDefs: ctrl.colDef,
                enableGridMenu: false,
                enableSorting: true,
                fastWatch: true,
                enableSelectAll: false,
                showGridFooter: true,
                showColumnFooter: false,
                enableFiltering: false,
                rowTemplate: `
                    <div
                        ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid"
                        ui-grid-one-bind-id-grid="rowRenderIndex + '-' + col.uid + '-cell'"
                        class="ui-grid-cell"
                        ng-click="grid.appScope.$lCtrl.editarCliente($event,row.entity)"
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

    ctrl.mostrarFlitrosTablas = function(){
          ctrl.tableOpts.enableFiltering = !ctrl.tableOpts.enableFiltering;
          ctrl.gridApi.core.notifyDataChange( uiGridConstants.dataChange.COLUMN );
    };

    ctrl.listadoFacturas = function($event, id)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'listado-facturas-cliente.html',
                controller: 'listadoFacturasClienteModalController',
                controllerAs: '$ctrl',
                size: 'xl',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                     	return id;
                    }
                }
              
            }).result.then((response) => { 
                    if(response != null)
                    {
                     
                      //ctrl.usuarios.unshift(response);
                      //data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                      //ctrl.lista_clientes.unshift(data);
                    }
                    
                },function ()
                {
                 
                });
    }

    ctrl.editarCliente = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'editar-cliente.html',
                controller: 'editarClineteModalController',
                controllerAs: '$ctrl',
                size: 'xl',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                     	return row;
                    }
                }
              
            }).result.then((response) => { 
                if(angular.isObject(response)){
                  ctrl.listarUsuarios();
                }
                
                    
                },function ()
                {
                 
                });
    }


    ctrl.nuevoCliente = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'crear-cliente.html',
                controller: 'crearClineteModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
            }).result.then((response) => { 
                    console.log(response);
                    ctrl.listarUsuarios();
                },function()
                {});
    };

    
   

    ctrl.deleteCliente = function ($event, id) {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      let confirm = $mdDialog.confirm()
          .title('¿Está seguro de eliminar?')
          .textContent('Esta acción será definitiva y no habrá forma de recuperar los datos.')
          .ariaLabel('Borrar usuario')
          .targetEvent($event)
          .ok('Borrar')
          .cancel('Cancelar')
      $mdDialog.show(confirm).then(function () {
        usuariosService.delete(id).then(function (response){
              toastr.success('Cliente eliminado')
              if(response.status === 200)
             
              ctrl.listarUsuarios();
              
          }, function (error) {
              toastr.error('Error al eliminar el cliente')
          });
      }, function () {
         
      })
  }
   
    ctrl.initTable();
    $scope.$on('left_menu_selection', function (event, data) 
    { 
     
      if (data == 'listado_usuarios') 
      {
          ctrl.listarUsuarios();
    
      }
    });

  }]
});
