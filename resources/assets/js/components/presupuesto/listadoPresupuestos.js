import {erp} from '../../app.js'

erp.component('listadoPresupuestos',{
  templateUrl: 'presupuestos-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','presupuestoService','FileSaver', 'moment',
   function listadoPresupuestosController($rootScope, $scope, $uibModal, $filter, toastr, presupuestoService, FileSaver, moment){
    var ctrl = this;
  
    ctrl.listarFacturasProveedores = function() 
    {

  		presupuestoService.listarFacturasProveedor().then(function success(response)
      {
        ctrl.lista_presupuestos = response.data;
        _.each(ctrl.lista_presupuestos, function (obj, i)
        {
            obj.fechafactura = moment(obj.fechafactura).format("DD/MM/YYYY");
            obj.numerolineas = parseInt(obj.numerolineas);
        });
      },
        function error(response){
            toastr.info('No se han encontrado facturas de proveedor');
            return '';
      });
    };


    ctrl.verPresupuesto = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-presupuesto-modal.html',
                controller: 'verPresupuestoModalController',
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


     ctrl.verTrimestreTotalPresupuestos = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ver-trimestre-proveedores-total-modal.html',
                controller: 'verTrimestreTotalPresupuestoModalController',
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
    ctrl.descargarPresupuestoPdf = function(row)
    {
       
        ctrl.loading = true;
        presupuestoService.getLineasFacturaProveedor({idfactura: row.idfactura}).then(function (response){
          ctrl.articulos = response.data;
          _.each(ctrl.articulos, function (obj, i)
          {
              obj.unidades = parseInt(obj.unidades);
              obj.precio = parseFloat(obj.precio).toFixed(2);
              obj.pordescuento = parseInt(obj.pordescuento) | 0;
              obj.importedescuento = parseFloat(obj.importedescuento).toFixed(2);
              obj.poriva = parseInt(obj.poriva) | 0;
              obj.importebruto = parseFloat(obj.importebruto).toFixed(2);

          });

          if(ctrl.articulos.length == 0){
            ctrl.articulos = [{
              codigoarticulo:'-',
                  descripcionarticulo:row.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(row.baseimponible).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:21,
                  importeneto: parseFloat(row.baseimponible).toFixed(2),
              },
              {
                codigoarticulo:'-',
                  descripcionarticulo:row.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(row.baseimponible2).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:10,
                  importeneto: parseFloat(row.baseimponible2).toFixed(2),
              },
              {
                codigoarticulo:'-',
                  descripcionarticulo:row.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(row.baseimponible3).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:4,
                  importeneto: parseFloat(row.baseimponible3).toFixed(2),
              },
              ]
          }

          presupuestoService.totalesIvasFacturaProveedores({idfactura: row.idfactura}).then(function (response){
          ctrl.totales_ivas = response.data;
          _.each(ctrl.totales_ivas, function (obj, i)
          {
            obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
            obj.poriva = parseFloat(obj.poriva).toFixed(2);
            obj.cuotaiva = parseFloat(obj.cuotaiva).toFixed(2);
          });


            let factrua_proveedor = {
              //logoempresa:  row.logoempresa,
              numerofactura: row.numerofactura,
              serie: row.serie,
              fechafactura: row.fechafactura,
              razonsocial: row.razonsocial,
              cifdni: row.cifdni,
              codigoproveedor: row.codigoproveedor,
              //domicilio: row.domicilio+', '+row.codigopostal+', '+row.poblacion+', '+row.provincia,
              importebruto: row.importebruto,
              importenetolineas: (row.importenetolineas == 0) ? row.sumabases:row.importenetolineas,
              baseimponible: row.baseimponible, 
              cuotaiva: row.totaliva,
              importeliquido: row.importeliquido,
              //observaciones: row.observaciones

            }

          if(angular.isObject(factrua_proveedor) && angular.isObject(ctrl.totales_ivas)&& angular.isObject(ctrl.articulos)){
              presupuestoService.crearPDFFacturaProveedor({presupuestocabecera: factrua_proveedor, totalesiva: ctrl.totales_ivas, articulos: ctrl.articulos});
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

    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_facturas_proveedores') 
      {
          ctrl.listarFacturasProveedores();
    
      }
    });

  }]
});
