import {erp} from '../../app.js';

erp.controller('planContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    ctrl.numerocontrato = detalle.numerocontrato;
    let data = {idcontrato:detalle.idcontrato};

    contratosService.planContrato(data).then(function success(response)
    {
        ctrl.lineas_plan = response.data;
       
        _.each(ctrl.lineas_plan, function (obj, i)
        {
          obj.fecha = moment(obj.fecha).format('DD/MM/YYYY');
          obj.fechafin = moment(obj.fechafin).format('DD/MM/YYYY');
          
        });
         console.log(ctrl.lineas_plan);
        
    },function error(response){
              toastr.info('No se han cargado los planes');
              return '';
        });

     ctrl.detallePlan = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'detalle-plan-contrato-modal.html',
                controller: 'detallePlanContratoModalController',
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
    }

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);