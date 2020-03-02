import {erp} from '../../app.js'

erp.component('listaOfertasClientes',{
  templateUrl: 'lista-ofertas-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','ofertasService','FileSaver', 'moment','uiGridConstants','i18nService',
   function listaClienteController($rootScope, $scope, $uibModal, $filter, toastr, ofertasService, FileSaver, moment,uiGridConstants,i18nService){
    var ctrl = this;
  
    ctrl.listarOfertas = function() 
    {

		ofertasService.getOfertasCliente().then(function success(response)
	    {
	      ctrl.listado_ofertas = response.data;
        _.each(response.data, function (obj, i)
        {
            obj.fechaoferta = moment(obj.fechaoferta).format("DD/MM/YYYY");
        });
          ctrl.tableOpts.data = []; 
          ctrl.tableOpts.data = ctrl.listado_ofertas;
          ctrl.tableOpts.columnDefs = ctrl.colDef;
        
	    },
	      function error(response){
	          toastr.info('No se han cargado las ofertas');
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
            ctrl.colDef = [{
                    displayName: 'Fecha oferta',
                    field: 'fechaoferta',
                    name: 'fechaoferta',
                    width: '10%',
                    minWidth: 50,
                    type: 'string',
                    cellClass: 'text-left',
                },
                {
                    displayName: 'Nº Oferta',
                    field: 'numerooferta',
                    name: 'numerooferta',
                    width: '10%',
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
                    width: '10%',
                    minWidth: 50,
                    enableCellEdit: false,
                    cellClass: 'text-left',
                   
                },
                {
                    displayName: 'Base imponible',
                    field: 'baseimponible',
                    name: 'baseimponible',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
                },
                {
                    displayName: 'IVA',
                    field: 'cuotaiva',
                    name: 'cuotaiva',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
                },
                {
                    displayName: 'Total Oferta',
                    field: 'importeliquido',
                    name: 'importeliquido',
                    width: '10%',
                    minWidth: 50,
                    cellClass: 'text-right',
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
                    ng-click="grid.appScope.$lCtrl.verOferta($event,row.entity)"
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


     ctrl.verOferta = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-oferta-modal.html',
                controller: 'verOfertasModalController',
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
    /*   
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
    }*/

   

    
  
    ctrl.initTable();
    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_ofertas_clientes') 
      {
          ctrl.listarOfertas();
    
      }
    });
     



  }]
});
