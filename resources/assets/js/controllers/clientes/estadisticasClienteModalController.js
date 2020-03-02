import {erp} from '../../app.js';

erp.controller('estadisticasClienteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle, Upload){
    
    var ctrl = this;
    console.log(detalle);
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.codigocliente = detalle.codigocliente;
    ctrl.codigoempresa = detalle.codigoempresa;
    
    clientes.informeAnual({codigocliente:detalle.codigocliente, codigoempresa: detalle.codigoempresa}).then(function success(response)
  	{
  	    ctrl.anual = response.data;
  		_.each(ctrl.anual, function (obj, i)
  	    {
  	        obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
  	        obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
  	        obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
  	        obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
  	        obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
  	        
  	    });

  	},function error(response){
  	        toastr.info('No se han cargado las facturas');
  	        return '';
  	});

  	clientes.informeTrimestral({codigocliente:detalle.codigocliente, codigoempresa: detalle.codigoempresa}).then(function success(response)
  	{
  	    ctrl.trimestral = response.data;
  	  	_.each(ctrl.trimestral, function (obj, i)
  	    {
  	        obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
  	        obj.importebruto = parseFloat(obj.importebruto).toFixed(2);
  	        obj.importedescuentolineas = parseFloat(obj.importedescuentolineas).toFixed(2);
  	        obj.importeliquido = parseFloat(obj.importeliquido).toFixed(2);
  	        obj.totaliva = parseFloat(obj.totaliva).toFixed(2);
  	        
  	    });

  	},function error(response){
  	        toastr.info('No se han cargado las facturas');
  	        return '';
  	});


  	ctrl.detalleTrimestreFacturas = function($event, row, codigocliente, codigoempresa)
    {
          $event.stopImmediatePropagation();
          $event.preventDefault();
           $uibModal.open({
                  animation: ctrl.animationsEnabled,
                  ariaLabelledBy: 'modal-title',
                  ariaDescribedBy: 'modal-body',
                  templateUrl: 'detalle-trimestre-facturas-modal.html',
                  controller: 'detalleTrimestreFacturasModalController',
                  controllerAs: '$ctrl',
                  size: 'lg',
                  scope: $scope, 
                   resolve: {
                      detalle: function()
                      {  
                      	row.codigocliente =  codigocliente;
                      	row.codigoempresa =  codigoempresa;
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

    ctrl.cancel = function ()
    {
      $uibModalInstance.dismiss('cancel');
    };
  
  }
]);