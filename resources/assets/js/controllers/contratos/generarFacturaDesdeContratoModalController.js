import {erp} from '../../app.js';

erp.controller('generarFacturaDesdeContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData','moment','contratosService','facturaService','articulos',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService, facturaService, articulos){
    
    var ctrl = this;
    
    ctrl.cabecera_factura = detalle.cabecera_factura[0];
    ctrl.lineas_factura = detalle.lineas_factura;
    console.log(ctrl.lineas_factura)
    //ctrl.descuento_total_factura = 0;
    //ctrl.hacerperiodica = 0;

    ctrl.ejercicio = new Date().getFullYear();
    ctrl.cambiarFecha = moment(new Date()).format("DD/MM/YYYY");

    /*$rootScope.$on('nuevaFechaFactura', function(event, data){
      ctrl.datos_nueva_factura[0].fecha = data.fecha;
      ctrl.datos_nueva_factura[0].ejercicio = data.ejercicio;
    })*/

    facturaService.getDatosNuevaFactura().then(function success(response)
    {
        ctrl.datos_nueva_factura = response.data;
        ctrl.datos_nueva_factura[0].numerofactura = ctrl.datos_nueva_factura[0].contador;
        ctrl.datos_nueva_factura[0].fecha =  ctrl.cambiarFecha;
        ctrl.datos_nueva_factura[0].ejercicio = ctrl.ejercicio;
    },function error(response){
          toastr.info('No se ha generado el numero de factura');
          return '';
    });

    articulos.getArticulosObsoletoNo().then(function success(response)
    {
          ctrl.articulos = response.data;
          _.each(ctrl.articulos, function (obj, i)
          {
              obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
          });
    },function error(response){
            toastr.info('No se han cargado datos de ventas');
            return '';
    });


    ctrl.nuevo = [
        {descripcionarticulo:'', comentario:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0},
        
    ];

    ctrl.hoja=[];
    ctrl.hoja = ctrl.lineas_factura;
    _.forEach(ctrl.hoja, function(obj, i){
        obj.descipcionarticulo = obj.descripcionarticulo;
        obj.comentario = '';
        obj.cantidad = obj.unidades;
        obj.precioventa = obj.precio;
        obj.descuento = obj.pordescuento;
        obj.porcentaje = obj.poriva;
        obj.liquido = obj.neto;

    });

    ctrl.hoja.push(ctrl.nuevo[0]);
    console.log(ctrl.hoja);

    

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);