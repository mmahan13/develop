import {erp} from '../../app.js';

erp.controller('detallePlanContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    
    //console.log(detalle)
    ctrl.fechainicio = detalle.fecha;
    ctrl.fechafin = detalle.fechafin;
    ctrl.procesado = parseInt(detalle.procesado);
    ctrl.facturado = parseInt(detalle.procesado) === 1 ? "Si" : "No";
    ctrl.importenetolineas = detalle.importenetolineas;


    contratosService.detallePlan({idplan:detalle.idplan}).then(function success(response)
	{
	      ctrl.detalle_plan = response.data;
          console.log(ctrl.detalle_plan)
	  _.each(ctrl.detalle_plan, function (obj, i)
	  {
        obj.unidades = parseInt(obj.unidades); 
        obj.pordescuento = parseInt(obj.pordescuento) | 0;
        obj.fechainicio = moment(obj.fechainicio).format('DD/MM/YYYY');
	    obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
	  });
	},function error(response){
	          toastr.info('No se han cargado los contratos');
	          return '';
	    });

    ctrl.descuentoaplicado = 0;
    $scope.$watch("$ctrl.detalle_plan", function(newCollection, oldValue) {
        if(angular.isObject(newCollection))
        {
            console.log(newCollection)
            _.each(newCollection, function (o, i)
            {
              o.importeneto = (parseInt(o.unidades)*parseFloat(o.importebruto));
              ctrl.descuentoaplicado = (parseInt(o.unidades)*parseFloat(o.importebruto)*o.pordescuento/100);
              o.importeneto = o.importeneto-ctrl.descuentoaplicado;
              o.importedescuento = ctrl.descuentoaplicado 
            });
        }   
    },true);
   


    ctrl.guardarCambios = function () {

        /*let datos = {idcontrato:ctrl.idcontrato, idlineacontrato:ctrl.idlineacontrato, unidades:ctrl.unidades, pordescuento:ctrl.pordescuento,precio:ctrl.precio};
        contratosService.guardarEdicion(datos).then(function success(response)
        {
            toastr.success('Datos actualizados');
            $uibModalInstance.close(response.data);
        },function error(response){
                  toastr.info('Los datos no se han actualizado');
                  return '';
        });  */  
    };
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);