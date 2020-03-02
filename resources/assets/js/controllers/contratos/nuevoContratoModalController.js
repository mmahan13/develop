import {erp} from '../../app.js';

erp.controller('nuevoContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','Upload',
    'MaterialCalendarData', 'moment','contratosService','clientes',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, Upload, MaterialCalendarData, moment, contratosService, clientes){
    
    var ctrl = this;
   
    clientes.getListaClientes().then(function success(response)
    {
        ctrl.lista_clientes = response.data;
        console.log(ctrl.lista_clientes)
        _.each(ctrl.lista_clientes, function (obj, i)
        {
            obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
        });
    },function error(response){
       toastr.info('No se han cargado datos de clientes');
       return '';
    });                     

     $scope.$broadcast('angucomplete-alt:changeInput', 'cliente_autocomplete', 
            _.find(ctrl.lista_clientes , function(o) { return o.codigocliente == row.codigocliente}));
      ctrl.ver_cif = false;
      ctrl.currentCliente = function(cliente_autocomplete)
      {  
        if (angular.isDefined(cliente_autocomplete))
        { 
          ctrl.ver_cif = true;
          ctrl.idcliente = cliente_autocomplete.originalObject.idcliente;
          ctrl.razonsocial = cliente_autocomplete.originalObject.razonsocial;
          ctrl.cifdni = cliente_autocomplete.originalObject.cifdni;
          ctrl.domicilio = cliente_autocomplete.originalObject.domicilio +', '+ cliente_autocomplete.originalObject.codigopostal+', '+ cliente_autocomplete.originalObject.poblacion +', '+ cliente_autocomplete.originalObject.provincia;
          ctrl.codigocliente = cliente_autocomplete.originalObject.codigocliente;
          ctrl.telefono = cliente_autocomplete.originalObject.telefono;
          ctrl.email1 = cliente_autocomplete.originalObject.email1;
          $scope.$broadcast('angucomplete-alt:clearInput','cliente_autocomplete');
        }
      };

    ctrl.crearContrato = function () {
        contratosService.nuevoContrato({idcliente:ctrl.idcliente}).then(function success(response)
        {
            toastr.success('Nuevo contrato creado correctamente');
            $uibModalInstance.close(response.data);
           
        },function error(response){
           toastr.info('Error al crear el contrato');
           return '';
        });   
    };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);

                                                                                          