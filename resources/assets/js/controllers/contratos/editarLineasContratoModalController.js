import {erp} from '../../app.js';

erp.controller('editarLineasContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    console.log(detalle)
    ctrl.idcontrato = detalle.idcontrato;
    ctrl.idlineacontrato = detalle.idlineacontrato;
    ctrl.fechainicio = detalle.fechainicio;
    ctrl.fechafinal = detalle.fechafinal;
    ctrl.descripcionarticulo = detalle.descripcionarticulo;
    ctrl.precio = detalle.precio;
    ctrl.unidades = detalle.unidades;
    ctrl.pordescuento = detalle.pordescuento;
    ctrl.descuento = detalle.descuento;
    ctrl.poriva = detalle.poriva;
    

    $scope.$watch("$ctrl.unidades", function(newValue, oldValue)
    {
       ctrl.importe = (newValue * parseFloat(ctrl.precio)) - parseFloat(ctrl.descuento);
    });

    $scope.$watch("$ctrl.precio", function(newValue, oldValue)
    {
       ctrl.importe = newValue - parseFloat(ctrl.descuento);
    });

    $scope.$watch("$ctrl.pordescuento", function(newValue, oldValue)
    {
       if(newValue > 0){
        ctrl.descuento = (parseFloat(ctrl.precio) * newValue)/100;
        ctrl.importe = parseFloat(ctrl.precio)- parseFloat(ctrl.descuento);
       }else{
            ctrl.descuento = parseFloat(0);
            ctrl.importe = ctrl.unidades * ctrl.precio;
       } 
       
    });

    ctrl.guardarCambiosLineaContrato = function () 
    {
        if(ctrl.precio == 0)
        {
            toastr.info('Debe añadir un precio para poder guardar');
            return false;
        } 

        let datos = {idcontrato:ctrl.idcontrato, idlineacontrato:ctrl.idlineacontrato, unidades:ctrl.unidades, pordescuento:ctrl.pordescuento,precio:ctrl.precio};
        contratosService.guardarEdicion(datos).then(function success(response)
        {
            toastr.success('Datos actualizados');
            $uibModalInstance.close(response.data);
        },function error(response){
                  toastr.info('Los datos no se han actualizado');
                  return '';
        });     
     
                
    };


    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);