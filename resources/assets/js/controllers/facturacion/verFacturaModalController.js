import {erp} from '../../app.js';

erp.controller('verFacturaModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','facturaService', 'detalle','FileSaver','contratosService',
'clientes',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, facturaService, detalle, FileSaver, contratosService, clientes){
    
    var ctrl = this;
    
    ctrl.id = detalle.id;
    ctrl.numerofactura = detalle.numerofactura;
    ctrl.fechafactura = detalle.fecha_factura;
    ctrl.seriefactura = detalle.seriefactura;
    
    clientes.getCliente({id_cliente:detalle.id_cliente}).then(function (response){
     
        ctrl.cliente = response.data;
        ctrl.razonsocial = ctrl.cliente.nombre;
        ctrl.cifdni = ctrl.cliente.dni;
    });
 
    
    ctrl.observacionesfactura = detalle.observacionesfactura;
    ctrl.importebruto = detalle.importebruto;
    ctrl.importedescuento = detalle.importedescuento;
   
    ctrl.subtotal = detalle.subtotal | 0;
    ctrl.pordescuento = detalle.pordescuento | 0;
    ctrl.baseimponible = detalle.baseimponible; 
    ctrl.totaliva = detalle.totaliva;
    ctrl.importeliquido = detalle.totalfactura


    facturaService.getLineasFactura({idfactura:ctrl.id}).then(function (response){
          ctrl.articulos = response.data;
    });
    
    facturaService.totalesIvas({idfactura:ctrl.id}).then(function (response){
          ctrl.totales_ivas = response.data;
    });
      
     ctrl.loading = false; 
     ctrl.crearPdf = function()
     {
        ctrl.loading = true;
        //let domicilio = ctrl.domicilio+', '+ctrl.codigopostal+', '+ctrl.poblacion+', '+ctrl.provincia;
        let factura = {
          numerofactura: ctrl.numerofactura,
              fechafactura: ctrl.fechafactura,
              razonsocial: ctrl.razonsocial,
              cifdni: ctrl.cifdni,
              codigocliente: ctrl.codigocliente,
              //domicilio: row.domicilio+', '+row.codigopostal+', '+row.poblacion+', '+row.provincia,
              importebruto: ctrl.importebruto,
              importenetolineas: ctrl.importenetolineas,
              importedescuento: parseInt(ctrl.importedescuento) | 0,
              importerecargo: ctrl.importerecargo | 0,
              porretencion: ctrl.porretencion | 0,
              importeretencion: ctrl.importeretencion | 0,
              subtotal: ctrl.subtotal | 0,
              pordescuento: ctrl.pordescuento | 0,
              baseimponible: ctrl.baseimponible, 
              totaliva: ctrl.totaliva,
              importeliquido: ctrl.importeliquido

        }

        

        facturaService.crearPDF({facturacabecera: factura, totalesiva: ctrl.totales_ivas, articulos: ctrl.articulos});
          $rootScope.$on('descargaOK', function(event, data)
          {
            if (angular.isObject(data)) {
                ctrl.loading = false;
            }
          })
          
     }
      
      ctrl.contratoVer = function($event)
      {
          $event.stopImmediatePropagation();
          $event.preventDefault();
         
          contratosService.getContrato({idalbaran:ctrl.idalbaran}).then(function success(response)
          {
              ctrl.contrato = response.data;
              
              _.each(ctrl.contrato, function (obj, i)
              {
                obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
                obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
                obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
              });

              $uibModal.open({
                  animation: ctrl.animationsEnabled,
                  ariaLabelledBy: 'modal-title',
                  ariaDescribedBy: 'modal-body',
                  templateUrl: 'datos-contrato-modal.html',
                  controller: 'datosContratoModalController',
                  controllerAs: '$ctrl',
                  size: 'lg',
                  scope: $scope, 
                   resolve: {
                      detalle: function()
                      {  
                        return ctrl.contrato[0];
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
          },function error(response){
                    toastr.info('No se han cargado los contratos');
                    return '';
            });


      }


      ctrl.informacionFinanciera = function($event,idalbaran)
      {
          $event.stopImmediatePropagation();
          $event.preventDefault();
          $uibModal.open({
              animation: ctrl.animationsEnabled,
              ariaLabelledBy: 'modal-title',
              ariaDescribedBy: 'modal-body',
              templateUrl: 'datos-financieros-modal.html',
              controller: 'datosFinancierosModalController',
              controllerAs: '$ctrl',
              size: 'lg',
              scope: $scope, 
               resolve: {
                  detalle: function()
                  {  
                    return idalbaran;
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


    ctrl.leerMas = function($event, descripcionlinea)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'leer-mas-modal.html',
                controller: 'leerMasModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                      return descripcionlinea;
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
  
      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);