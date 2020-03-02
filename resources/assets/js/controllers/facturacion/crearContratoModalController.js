import {erp} from '../../app.js';

erp.controller('crearContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload','MaterialCalendarData',
	'moment',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment){
    
    var ctrl = this;
    ctrl.fecha_inicio = detalle;
    //ctrl.fecha_fin = moment(new Date()).format("DD/MM/YYYY");
    //ctrl.fecha_fin =  moment(new Date(ctrl.fecha_inicio)).add(1, 'years').calendar();
    //ctrl.fecha_fin = moment(ctrl.fecha_fin).format("DD/MM/YYYY");

    /*$rootScope.$on('fechainicio', function(event, data){
        ctrl.fecha_inicio = data.fecha;
        console.log(ctrl.fecha_inicio);
        ctrl.fecha_fin =  moment(new Date(ctrl.fecha_inicio)).add(1, 'years').calendar();
        ctrl.fecha_fin = moment(ctrl.fecha_fin).format("DD/MM/YYYY");
    })
    $rootScope.$on('fechafin', function(event, data){
                
        ctrl.fecha_fin = data.fecha  
        ctrl.total_dias_contrato = moment(data.fecha).add(1, 'days').calendar();
    })*/

     ctrl.plan = {};
        ctrl.TiposPlan = [
            {id:0, tipo:'Una véz al mes', value: '1'},
            {id:1, tipo:'Una véz al año', value: '2'},
        ];
        //inicializo el option select
        ctrl.plan.tipo = ctrl.TiposPlan[0];
  
    ctrl.duracion = {};
        ctrl.TiposMeses = [
            /*{id:0, tipo:'1 año', value: '11'},*/
            {id:1, tipo:'2 años', value: '23'},
        ];
        //inicializo el option select
        ctrl.duracion.tipo = ctrl.TiposMeses[0];

    ctrl.generarContrato = function () {
        //.log(ctrl.plan.tipo)
        //console.log(ctrl.duracion.tipo)
        $uibModalInstance.close({contrato:'aceptar', periodicidad: ctrl.plan.tipo.value, duracion: ctrl.duracion.tipo.value});
    };

    ctrl.cancel = function () {
        $uibModalInstance.close({contrato:'noaceptar'});
    };
  }
]);