import {erp} from '../../app.js';

erp.controller('listadoFacturasClienteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle','Upload',
'uiGridConstants', 'i18nService','facturaService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle, Upload, uiGridConstants, i18nService,facturaService){
    
      var ctrl = this;
      ctrl.tableOpts = {};
     
      clientes.facturasCliente({idcliente:detalle}).then(function success(response)
      {
          console.log(response.data);
         
        ctrl.tableOpts.data = []; 
        ctrl.tableOpts.data = response.data;
        _.each(ctrl.tableOpts.data, function (obj, i)
        {
            obj.fecha_factura = moment(obj.fecha_factura).format("DD/MM/YYYY");
            
        });
        ctrl.tableOpts.columnDefs = ctrl.colDef;
         
        
      },
        function error(response){
            toastr.info('No se han cargado las facturas');
            return '';
      }).finally(() => {
        setTimeout(() => { // para arreglar el ancho de la tabla y que se ocultan columnas
            $(window).resize();
            ctrl.gridApi.core.refresh();
        }, 500)
        });

        ctrl.initTable = function ()
        {
            i18nService.setCurrentLang('es');
            ctrl.uiGridConstants = uiGridConstants;
    
                ctrl.colDef = [
                    {
                        displayName: 'Fecha',
                        field: 'fecha_factura',
                        name: 'fecha_factura',
                        width: '30%',
                        minWidth: 100,
                        //cellTemplate: `<button ng-click="grid.appScope.$ctrl.changeParte($event,row.entity)"><i class="fa fa-lg fa-fw" ng-class="{'fa-unlock': row.entity.estado_parte === 'A', 'fa-lock': row.entity.estado_parte === 'F' || row.entity.estado_parte === 'C', 'fa-unlock-alt': row.entity.estado_parte === 'R'}" aria-hidden="true"></i></button>`,
                        type: 'string',
                        cellClass: 'text-left',
                    },
                    {
                        displayName: 'Factura',
                        field: 'numerofactura',
                        name: 'numerofactura',
                        width: '30%',
                        minWidth: 100,
                        type: 'number',
                        cellClass: 'text-left',
                    },
                    {
                      displayName: 'Serie',
                      field: 'seriefactura',
                      name: 'seriefactura',
                      width: '20%',
                      minWidth: 100,
                      type: 'number',
                      cellClass: 'text-left',
                  },
                    {
                        displayName: 'Total factura',
                        field: 'totalfactura',
                        cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                        aggregationType: uiGridConstants.aggregationTypes.sum,
                        footerCellTemplate: '<div class="ui-grid-cell-contents" >Total: {{col.getAggregationValue() | number:2 }} €</div>',
                        name: 'totalfactura',
                        width: '20%',
                        minWidth: 100,
                        enableCellEdit: false,
                        cellClass: 'text-left',
                    },
                    
                    
                ];
                
                ctrl.tableOpts = {
                    columnDefs: ctrl.colDef,
                    enableGridMenu: false,
                    enableSorting: true,
                    fastWatch: true,
                    enableSelectAll: false,
                    showGridFooter: true,
                    //gridFooterTemplate: '<div class="ui-grid-cell-contents">Facturas Totales: {{col.getAggregationValue()}}</div>',
                    showColumnFooter: true,
                    enableFiltering: false,
                    rowTemplate: `
                        <div
                            ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid"
                            ui-grid-one-bind-id-grid="rowRenderIndex + '-' + col.uid + '-cell'"
                            class="ui-grid-cell"
                            ng-click="grid.appScope.$ctrl.descargarFactura($event,row)"
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

    ctrl.descargarFactura = function($event, row)
    {
        $event.stopImmediatePropagation(); $event.preventDefault();
        facturaService.crearPDF({facturacabecera:row}).then(function success(response){
        
        $rootScope.$on('descargaOK', function(event, data)
        {
            console.log(data);
          if (angular.isObject(data)) {
              ctrl.loading = false;
             
          }
        })
        
        },
        function error(response){
            toastr.info('No se han cargado las facturas');
            return '';
      });
        
        /**/
         
    }
     
     ctrl.initTable();
      ctrl.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
    }
]);