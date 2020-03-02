import {erp} from '../app.js'

erp.component('cambiarFechaComponent',{
   template: `<a href="#" style="color: black;" ng-model="$lCtrl.cambiarFecha"
    ng-click="$lCtrl.mostrarCalendario($event, $lCtrl.cambiarFecha, $lCtrl.desdeDonde, $lCtrl.lineaContrato)">{% $lCtrl.cambiarFecha %} 
    <i ng-if="$lCtrl.desdeDonde == 9 || $lCtrl.desdeDonde == 10" class="fa fa-calendar" aria-hidden="true"></i></a> `, 

bindings:{ 
    cambiarFecha : '<',
    desdeDonde: '<',
    lineaContrato: '<',
},

controllerAs:'$lCtrl',
 
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','FileSaver', 'moment',
   function fechaController($rootScope, $scope, $uibModal, $filter, toastr, FileSaver, moment){
    var ctrl = this;
  
   
    
    ctrl.mostrarCalendario = function($event, cambiarFecha, desdeDonde)
    {
        ctrl.desdedonde = parseInt(desdeDonde);
        $event.stopImmediatePropagation();
        $event.preventDefault();
        $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'calendario-modal.html',
                controller: 'calendarioModalController',
                controllerAs: '$ctrl',
                size: 'xs',
                /*resolve: {
                    detalle: function()
                    {  
                     	return lineacontrato;
                    }
                }*/
              
            }).result.then((response) => { 
                    
                    if (response != null)
                    {
                        
                        let data = response;
                        console.log(data)
                        if(angular.isObject(desdeDonde)){
                            let datos ={value:desdeDonde, fecha:data.fecha}
                            $rootScope.$emit('fechalinea', datos);
                        }
                        if(ctrl.desdedonde == 0)
                        {
                           $rootScope.$emit('nuevaFechaFactura', data); 
                        }
                        if(ctrl.desdedonde == 1)
                        {
                            $rootScope.$emit('nuevaFechaPresupuesto', data);
                        } 
                        if(ctrl.desdedonde == 2)
                        {
                            $rootScope.$emit('fechaActivacionCabeceraContrato', {fechaactivacion:data.fecha, idcontrato:lineacontrato.idcontrato});
                        } 
                        if(ctrl.desdedonde == 3)
                        {
                            $rootScope.$emit('fechainicio', data);
                        }   
                        if(ctrl.desdedonde == 4)
                        {
                            $rootScope.$emit('fechafin', data);
                        }   
                        if(ctrl.desdedonde == 5)
                        {
                            $rootScope.$emit('inicioContrato', data);
                        }
                        if(ctrl.desdedonde == 6)
                        {
                            $rootScope.$emit('actualizarFechaLineaContrato', {fechainicio:data.fecha, idcontrato:lineacontrato.idcontrato, idlineacontrato: lineacontrato.idlineacontrato, inicio:0});
                        }  
                        if(ctrl.desdedonde == 7)
                        {
                            $rootScope.$emit('actualizarFechaLineaContrato', {fechafin:data.fecha, idcontrato:lineacontrato.idcontrato, idlineacontrato: lineacontrato.idlineacontrato, inicio:1});
                        } 
                        if(ctrl.desdedonde == 8)
                        {
                            $rootScope.$emit('finalContrato', data);
                        }
                        if(ctrl.desdedonde == 9)
                        {
                            $rootScope.$emit('fechai', data);
                        }
                        if(ctrl.desdedonde == 10)
                        {
                            $rootScope.$emit('fechaf', data);
                        }
                        if(ctrl.desdedonde == 11)
                        {
                            lineacontrato.nuevafechaactivacion = data.fecha;
                            $rootScope.$emit('fechaActivacionLineaContrato', {idlineacontrato:lineacontrato.idlineacontrato, nuevafechaactivacion:lineacontrato.nuevafechaactivacion, fechainicio:lineacontrato.fechainicio});
                        }

                    }
                },
                function ()
                {
                    // dismiss
                });
    }

  


  }]
});
