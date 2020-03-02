import {erp} from '../../app.js';

erp.controller('verOfertasModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','ofertasService', 'detalle','FileSaver','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, ofertasService, detalle, FileSaver, contratosService){
    
    var ctrl = this;
    console.log(detalle);
    ctrl.idoferta = detalle.idoferta;
    ctrl.numerooferta = detalle.numerooferta;
    
    ctrl.fechaoferta = detalle.fechaoferta;
    ctrl.numerooferta = detalle.numerooferta;
    ctrl.tipo = detalle.tipo;
    
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.cifdni = detalle.cifdni;
    ctrl.codigocliente = detalle.codigocliente;
    ctrl.codigoempresa = detalle.codigoempresa;
    ctrl.observacionesfactura = detalle.observacionesfactura;

    ctrl.importebruto = detalle.importebruto;
    ctrl.importenetolineas = detalle.importenetolineas;
    ctrl.importedescuento = detalle.importedescuento;
    ctrl.importerecargo = detalle.importerecargo;
    ctrl.porretencion = detalle.porretencion;
    ctrl.importeretencion = detalle.importeretencion;
    ctrl.subtotal = detalle.subtotal;
    ctrl.pordescuento = detalle.pordescuento;
    ctrl.baseimponible = detalle.baseimponible; 
    ctrl.totaliva = detalle.cuotaiva;
    ctrl.importeliquido = detalle.importeliquido


    ofertasService.getLineasOferta({idoferta:ctrl.idoferta}).then(function (response){
          ctrl.articulos = response.data;
        
          _.each(ctrl.articulos, function (obj, i)
          {
              obj.unidades = parseInt(obj.unidades);
              obj.precio = parseFloat(obj.precio).toFixed(2);
              obj.pordescuento = parseInt(obj.pordescuento) | 0;
              obj.poriva = parseInt(obj.poriva) | 0;
              obj.importebruto = parseFloat(obj.importebruto).toFixed(2);

          });
          
    });
    
    ofertasService.totalesIvas({idoferta:ctrl.idoferta}).then(function (response){
          ctrl.totales_ivas = response.data;
    });
      
     ctrl.loading = false; 
     ctrl.crearPdf = function()
     {
        ctrl.loading = true;
        let domicilio = ctrl.domicilio+', '+ctrl.codigopostal+', '+ctrl.poblacion+', '+ctrl.provincia;
        let oferta = {
              numerooferta: ctrl.numerooferta,
              fechaoferta: ctrl.fechaoferta,
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

        

        facturaService.crearPDF({facturacabecera: oferta, totalesiva: ctrl.totales_ivas, articulos: ctrl.articulos});
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