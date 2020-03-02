import {erp} from '../../app.js'

erp.component('listadoFacturasLotes',{
  templateUrl: 'lote-facturas-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','facturaService','FileSaver', 'moment',
   function listadoFacturasController($rootScope, $scope, $uibModal, $filter, toastr, facturaService, FileSaver, moment){
    var ctrl = this;
  
    ctrl.listarFacturasLote = function() 
    {

  		facturaService.getListaLotesFacturas().then(function success(response)
  	  {
  	        ctrl.lista_lotes_facturas = response.data;
            console.log(ctrl.lista_lotes_facturas)
            _.each(ctrl.lista_lotes_facturas, function (obj, i)
  	        {
              obj.fechafactura = moment(obj.fechafactura).format("DD/MM/YYYY");
  	        });
  	   },
  	      function error(response){
  	          toastr.info('No hay lotes de facturas');
  	          return '';
  	   });

	   
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

    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_factura_lotes') 
      {
          ctrl.listarFacturasLote();
    
      }
    });
           

  }]
});
