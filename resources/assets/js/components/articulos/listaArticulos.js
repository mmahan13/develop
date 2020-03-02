import {erp} from '../../app.js'

erp.component('listaArticulos',{
   template: `
   <button type="button" class="btn btn-success btn-sm float-right" style="margin-right: 2rem;" ng-click="$lCtrl.nuevoArticulo($event)">Nuevo producto</button>
<button id='toggleFiltering' style="margin-right: 0.5rem;" ng-click="$lCtrl.mostrarFlitrosTablas()" class="btn btn-info btn-sm float-right"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>

<div class="table-responsive">
 <div id="grid1" ui-grid="$lCtrl.tableOpts"  ui-grid-auto-resize  ui-grid-resize-columns  class="grid"></div>
</div>`,
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','articulos','FileSaver', 'moment','uiGridConstants','i18nService','$mdDialog',
   function listaClienteController($rootScope, $scope, $uibModal, $filter, toastr, articulos, FileSaver, moment, uiGridConstants, i18nService, $mdDialog){
    var ctrl = this;
         ctrl.tableOpts = {};
       
        ctrl.listarArticulos = function()
        {
           
            articulos.getArticulos().then(function success(response)
            {
               ctrl.tableOpts.data = []; 
               ctrl.tableOpts.data = response.data;
               ctrl.tableOpts.columnDefs = ctrl.colDef;
               //console.log(ctrl.tableOpts.data);
                    /*_.forEach(ctrl.gridOptions.data,  function(obj,i){
                      obj.precioventa = parseFloat(obj.precioventa).toFixed(2);
                  });*/
                  
            },function error(response){
                toastr.info('No se han cargado los artículos');
                return '';
            }).finally(() => {
                setTimeout(() => { // para arreglar el ancho de la tabla y que se ocultan columnas
                    $(window).resize();
                    ctrl.gridApi.core.refresh();
                }, 500)
            });

        }

        
        ctrl.initTable = function ()
        {
            i18nService.setCurrentLang('es');
            ctrl.uiGridConstants = uiGridConstants;
              

                ctrl.colDef = [
                    
                    {
                        displayName: 'Referencia',
                        field: 'ref',
                        name: 'ref',
                        width: '10%',
                        minWidth: 100,
                        type: 'number',
                        cellClass: 'text-right',
                    },
                    {
                        displayName: 'Producto',
                        field: 'producto',
                        name: 'producto',
                        width: '60%',
                        minWidth: 100,
                        cellClass: 'text-left',
                    },
                    {
                        displayName: 'Tipo IVA',
                        field: 'tipoiva',
                        name: 'tipoiva',
                        width: '20%',
                        minWidth: 100,
                        //cellTemplate: `<button ng-click="grid.appScope.$ctrl.changeParte($event,row.entity)"><i class="fa fa-lg fa-fw" ng-class="{'fa-unlock': row.entity.estado_parte === 'A', 'fa-lock': row.entity.estado_parte === 'F' || row.entity.estado_parte === 'C', 'fa-unlock-alt': row.entity.estado_parte === 'R'}" aria-hidden="true"></i></button>`,
                        type: 'string',
                        cellClass: 'text-left',
                    },
                    {
                        displayName: 'IVA %',
                        field: 'poriva',
                        name: 'poriva',
                        width: '5%',
                        minWidth:100,
                        cellClass: 'text-right',
                        
                    },
                    {
                        displayName: '',
                        field: 'id',
                        name: 'id',
                        width: '5%',
                        minWidth: 100,
                        cellClass: 'text-center',
                        cellTemplate: `<div class="ui-grid-cell-contents" ng-click="grid.appScope.$lCtrl.deleteArticulo($event,row.entity.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></div>`,
                      
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
                            ng-click="grid.appScope.$lCtrl.editarArticulo($event,row.entity)"
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

        ctrl.verProducto = function($event, row)
        {
           // console.log(row);
            $event.stopImmediatePropagation();
            $event.preventDefault();
             $uibModal.open({
                    animation: ctrl.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'ver-producto-modal.html',
                    controller: 'verProductoModalController',
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
       
    

    ctrl.editarArticulo = function($event, row)
    {
        
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'editar-articulo-modal.html',
                controller: 'editarArticuloModalController',
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
                        if(angular.isObject(response)){
                            ctrl.listarArticulos();
                        }
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.deleteArticulo = function ($event, id) {
        $event.stopImmediatePropagation();
        $event.preventDefault();
        let confirm = $mdDialog.confirm()
            .title('¿Está seguro de eliminar?')
            .textContent('Esta acción será definitiva y no habrá forma de recuperar los datos.')
            .ariaLabel('Borrar producto')
            .targetEvent($event)
            .ok('Borrar')
            .cancel('Cancelar')
        $mdDialog.show(confirm).then(function () {
            articulos.delete(id).then(function (response){
                toastr.success('Producto eliminado')
                if(response.status === 200)
               
                ctrl.listarArticulos();
                
            }, function (error) {
                toastr.error('Error al eliminar el producto')
            });
        }, function () {
           
        })
    }

    ctrl.nuevoArticulo = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'nuevo-articulo-modal.html',
                controller: 'nuevoArticuloModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope
            }).result.then((response) => { 
                    if (response != null)
                    {
                        if(angular.isObject(response)){
                            ctrl.listarArticulos();
                        }
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
      if(data == 'lista_articulos')
      {
        ctrl.listarArticulos();    
      }
    });



  }]
});
