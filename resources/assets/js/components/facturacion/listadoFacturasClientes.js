import {erp} from '../../app.js'

erp.component('listadoFacturasClientes',{
  templateUrl: 'facturas-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','facturaService','FileSaver', 'moment','uiGridConstants','i18nService','clientes',
   function listadoFacturasController($rootScope, $scope, $uibModal, $filter, toastr, facturaService, FileSaver, moment,uiGridConstants,i18nService, clientes){
    var ctrl = this;
  
    ctrl.listarFacturas = function() 
    {

        clientes.getListaFacturas().then(function success(response)
        {
           
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

	   
    };


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
                            ng-click="grid.appScope.$lCtrl.verFactura($event,row.entity)"
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

    ctrl.verTrimestreTotal = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-trimestre-total-modal.html',
                controller: 'verTrimestreTotalModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 /*resolve: {
                    detalle: function()
                    {  
                      return row;
                    }
                }*/
              
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

    
    ctrl.loading = false;
    ctrl.descargarPdf = function(row)
    {   
     
        ctrl.loading = true;
        facturaService.getLineasFactura({idfactura: row.idfactura}).then(function (response){
                ctrl.articulos = response.data;
                _.each(ctrl.articulos, function (obj, i)
                {
                    obj.unidades = parseInt(obj.unidades);
                    obj.precio = parseFloat(obj.precio).toFixed(2);
                    obj.pordescuento = parseInt(obj.pordescuento) | 0;
                    obj.poriva = parseInt(obj.poriva) | 0;
                    obj.importebruto = parseFloat(obj.importebruto).toFixed(2);

                });


        facturaService.totalesIvas({idfactura:row.idfactura}).then(function (response){
            ctrl.totales_ivas = response.data;
         

            let factura = {
              
              numerofactura: row.numerofactura,
              fechafactura: row.fechafactura,
              razonsocial: row.razonsocial,
              cifdni: row.cifdni,
              codigocliente: row.codigocliente,
              //domicilio: row.domicilio+', '+row.codigopostal+', '+row.poblacion+', '+row.provincia,
              importebruto: row.importebruto,
              importenetolineas: row.importenetolineas,
              importedescuento: parseInt(row.importedescuento) | 0,
              importerecargo: row.importerecargo | 0,
              porretencion: row.porretencion | 0,
              importeretencion: row.importeretencion | 0,
              subtotal: row.subtotal | 0,
              pordescuento: row.pordescuento | 0,
              baseimponible: row.baseimponible, 
              totaliva: row.cuotaiva,
              importeliquido: row.importeliquido

            }

          if(angular.isObject(factura) && angular.isObject(ctrl.totales_ivas)&& angular.isObject(ctrl.articulos))
          {
              facturaService.crearPDF({facturacabecera: factura, totalesiva: ctrl.totales_ivas, articulos: ctrl.articulos});
                $rootScope.$on('descargaOK', function(event, data)
                {
                  if (angular.isObject(data)) {
                      ctrl.loading = false;
                     
                  }
                })
          }
               
          });
    });
 }

    ctrl.initTable();
    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_facturas_clientes') 
      {
          ctrl.listarFacturas();
    
      }
    });
           

  }]
});
