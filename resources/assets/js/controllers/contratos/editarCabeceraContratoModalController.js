import {erp} from '../../app.js';

erp.controller('editarCabeceraContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    ctrl.idcontrato = detalle.idcontrato;
    ctrl.importenetolineas = detalle.importenetolineas;
    ctrl.pordescuento = detalle.pordescuento | 0;
    ctrl.importedescuento = detalle.importedescuento | 0;
    ctrl.importeneto = detalle.importeneto;
    ctrl.totaliva = detalle.totaliva;
    ctrl.importeliquido = detalle.importeliquido;
    
    $scope.$watch("$ctrl.pordescuento", function(newValue, oldValue)
    {

       if(newValue > 0){
            ctrl.importedescuento = (parseFloat(ctrl.importenetolineas) * newValue)/100;
            ctrl.importeneto = parseFloat(ctrl.importenetolineas)- parseFloat(ctrl.importedescuento);
            ctrl.totaliva = (parseFloat(ctrl.importeneto) * 21) / 100;
            ctrl.importeliquido = parseFloat(ctrl.importeneto)+ parseFloat(ctrl.totaliva);
       }else{
            ctrl.importedescuento = parseFloat(0);
            ctrl.importeneto = parseFloat(ctrl.importenetolineas);
            ctrl.totaliva = (parseFloat(ctrl.importeneto) * 21) / 100;
            ctrl.importeliquido = parseFloat(ctrl.importeneto)+ parseFloat(ctrl.totaliva);
       } 
       
    });

   ctrl.guardarCambiosCabeceraContrato = function () 
    {
        let datos = {idcontrato:ctrl.idcontrato, pordescuento:ctrl.pordescuento};
        contratosService.guardarEdicionCabecera(datos).then(function success(response)
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