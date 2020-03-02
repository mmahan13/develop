import {erp} from '../../app.js'

erp.component('listadoFacturasClientes',{
  templateUrl: 'facturas-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','facturaService','FileSaver', 'moment','uiGridConstants','i18nService',
   function listadoFacturasController($rootScope, $scope, $uibModal, $filter, toastr, facturaService, FileSaver, moment,uiGridConstants,i18nService){
    var ctrl = this;
  
    ctrl.listarFacturas = function() 
    {

  		facturaService.getListaFacturas().then(function success(response)
  	    {
  	        ctrl.lista_facturas = response.data;
            _.each(ctrl.lista_facturas, function (obj, i)
  	        {
              obj.fechafactura = moment(obj.fechafactura).format("DD/MM/YYYY");
  	        });
            ctrl.tableOpts.data = []; 
            ctrl.tableOpts.data = ctrl.lista_facturas;
            ctrl.tableOpts.columnDefs = ctrl.colDef;
  	    },
  	      function error(response){
  	          toastr.info('No se han encotrado oferta');
  	          return '';
  	    }).finally(() => {
                setTimeout(() => {
                    $(window).resize();
                    ctrl.gridApi.core.refresh();
                }, 500)
            });

	   
    };


    ctrl.initTable = function ()
      {
            i18nService.setCurrentLang('es');
            ctrl.uiGridConstants = uiGridConstants;
            ctrl.colDef = [{
                    displayName: 'Fecha',
                    field: 'fechafactura',
                    name: 'fechafactura',
                    width: '6%',
                    minWidth: 50,
                    type: 'string',
                    cellClass: 'text-left',
                },
                {
                    displayName: 'Nº Factura',
                    field: 'numerofactura',
                    name: 'numerofactura',
                    width: '7%',
                    minWidth: 50,
                    type: 'string',
                    cellClass: 'text-right',
                },
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
                    width: '6%',
                    minWidth: 50,
                    enableCellEdit: false,
                    cellClass: 'text-left',
                },
                {
                    displayName: 'Importe Bruto',
                    field: 'importenetolineas',
                    name: 'importenetolineas',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'Dto',
                    field: 'importedescuento',
                    name: 'importedescuento',
                    width: '6%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'Base imponible',
                    field: 'baseimponible',
                    name: 'baseimponible',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'IVA',
                    field: 'cuotaiva',
                    name: 'cuotaiva',
                    width: '6%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'Recargo',
                    field: 'importerecargo',
                    name: 'importerecargo',
                    width: '6%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'Subtotal',
                    field: 'subtotal',
                    name: 'subtotal',
                    width: '7%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                {
                    displayName: 'Retención',
                    field: 'importeretencion',
                    name: 'importeretencion',
                    width: '7%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
                 {
                    displayName: 'Total Factura',
                    field: 'importeliquido',
                    name: 'importeliquido',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
                    cellTemplate: `<div class="ui-grid-cell-contents">{% COL_FIELD | number:2 %}</div>`,
                },
            ];
                
            ctrl.tableOpts = {
                columnDefs: ctrl.colDef,
                enableGridMenu: false,
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
