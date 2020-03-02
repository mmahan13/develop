import {erp} from '../../app.js';

erp.controller('verPresupuestoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService', 'detalle','FileSaver',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, detalle, FileSaver){
    
    var ctrl = this;
    console.log(detalle)
    ctrl.serie = detalle.serie;
    ctrl.numerofactura = detalle.numerofactura;
    ctrl.fechafactura = detalle.fechafactura;
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.cifdni = detalle.cifdni;
    ctrl.codigoproveedor = detalle.codigoproveedor;

    ctrl.importerecargo = detalle.importerecargo;
    ctrl.porretencion = detalle.porretencion;
    ctrl.importeretencion = detalle.importeretencion;
    ctrl.sindescuentoretencion = detalle.sindescuentoretencion;
   
    ctrl.importebruto = detalle.importebruto;
    ctrl.importenetolineas = (detalle.importenetolineas == 0) ? detalle.sumabases:detalle.importenetolineas;
    ctrl.cuotaiva = detalle.totaliva;
    ctrl.importedescuento = detalle.importedescuento;
    ctrl.pordescuento = detalle.pordescuento;

    ctrl.importeneto = detalle.importeneto; 
    ctrl.baseimponible = detalle.sumabases;
    ctrl.importeliquido = detalle.importeliquido


    //ctrl.domicilio = detalle.domicilio;
    //ctrl.codigopostal = detalle.codigopostal;
    //ctrl.poblacion = detalle.poblacion;
    //ctrl.provincia = detalle.provincia;
    //ctrl.observaciones = detalle.observaciones;

    presupuestoService.getLineasFacturaProveedor({idfactura: detalle.idfactura}).then(function (response){
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
                  descripcionarticulo:detalle.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(detalle.baseimponible).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:21,
                  importeneto: parseFloat(detalle.baseimponible).toFixed(2),
              },
              {
                codigoarticulo:'-',
                  descripcionarticulo:detalle.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(detalle.baseimponible2).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:10,
                  importeneto: parseFloat(detalle.baseimponible2).toFixed(2),
              },
              {
                codigoarticulo:'-',
                  descripcionarticulo:detalle.decripcionfactura,
                  descripcionlinea:'',
                  unidades: parseInt(1),
                  precio: parseFloat(detalle.baseimponible3).toFixed(2),
                  pordescuento: parseInt(0),
                  importedescuento: parseFloat(0),
                  poriva:4,
                  importeneto: parseFloat(detalle.baseimponible3).toFixed(2),
              },
              ]
          }
          
    });
    
    presupuestoService.totalesIvasFacturaProveedores({idfactura: detalle.idfactura}).then(function (response){
          ctrl.totales_ivas = response.data;

          _.each(ctrl.totales_ivas, function (obj, i)
          {
            obj.baseimponible = parseFloat(obj.baseimponible).toFixed(2);
            obj.poriva = parseFloat(obj.poriva).toFixed(2);
            obj.cuotaiva = parseFloat(obj.cuotaiva).toFixed(2);
          });
     
    });

    

   
      
    ctrl.loading = false;  
     ctrl.crearPdfProveedor = function()
     {
        ctrl.loading = true;
        //let domicilio = ctrl.domicilio+', '+ctrl.codigopostal+', '+ctrl.poblacion+', '+ctrl.provincia;
        let presupuesto = {
          //logoempresa:  ctrl.logoempresa,
          numerofactura: ctrl.numerofactura,
          serie: ctrl.serie,
          fechafactura: ctrl.fechafactura,
          razonsocial: ctrl.razonsocial,
          cifdni: ctrl.cifdni,
          codigoproveedor: ctrl.codigoproveedor,
          //domicilio: domicilio,
          importebruto: ctrl.importebruto,
          importenetolineas: ctrl.importenetolineas,
          baseimponible: ctrl.baseimponible, 
          cuotaiva: ctrl.cuotaiva,
          importeliquido: ctrl.importeliquido,
          //observaciones: ctrl.observaciones,

        }

        presupuestoService.crearPDFFacturaProveedor({presupuestocabecera: presupuesto, totalesiva: ctrl.totales_ivas, articulos: ctrl.articulos});
         $rootScope.$on('descargaOK', function(event, data)
          {
            if (angular.isObject(data)) {
                ctrl.loading = false;
            }
          })
      
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