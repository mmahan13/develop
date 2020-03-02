import {erp} from '../../app.js';

erp.controller('listadoArticulosCompradosModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle, Upload){
    
      var ctrl = this;
      //console.log(detalle);
      ctrl.razonsocial = detalle.razonsocial;
     

    clientes.comprasCliente({codigocliente:detalle.codigocliente, codigoempresa: detalle.codigoempresa}).then(function success(response)
    {
      ctrl.lista_compra = response.data;
      //console.log(ctrl.lista_compra)
      ctrl.total = 0;
      _.each(ctrl.lista_compra, function (obj, i)
        {
          obj.unidades = parseInt(obj.unidades);
          obj.poriva = parseInt(obj.poriva)
          obj.importedescuento = parseFloat(obj.importedescuento);
          obj.importeneto = parseFloat(obj.importeneto);
          obj.importeliquido = parseFloat(obj.importeliquido);
          obj.totaliva = parseFloat(obj.totaliva);
          obj.fechalinea = moment(obj.fechalinea).format("DD/MM/YYYY");
          ctrl.total += parseFloat(obj.importeliquido);
        });
    },
      function error(response){
          toastr.info('No se han cargado las facturas');
          return '';
    });

    ctrl.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
    }
]);