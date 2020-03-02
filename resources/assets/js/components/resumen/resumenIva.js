import {erp} from '../../app.js'

erp.component('resumenIva',{
  templateUrl: 'resumen-iva-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','resumenService','FileSaver', 'moment',
   function resumenIvaController($rootScope, $scope, $uibModal, $filter, toastr, resumenService, FileSaver, moment){
    var ctrl = this;
  
   
  		/*resumenService.emitidas().then(function success(response)
	    {
	        ctrl.emitidas = response.data;
         
          _.each(ctrl.emitidas, function (obj, i)
	        {
            obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
            obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
            obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
            obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
            obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
            
	        });
	    },
  	      function error(response){
  	          toastr.info('No se han cargado las facturas');
  	          return '';
  	    });

      resumenService.recibidas().then(function success(response)
      {
          ctrl.recibidas = response.data;
         
          _.each(ctrl.recibidas, function (obj, i)
          {
            obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
            obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
            obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
            obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
            obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
            
          });
      },
          function error(response){
              toastr.info('No se han cargado las facturas');
              return '';
        });*/

	   
  
   
    /*ctrl.verFactura = function($event, row)
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
    }*/

        

  }]
});
