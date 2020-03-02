import {erp} from '../../app.js';

erp.controller('articulosProveedorModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','presupuestoService', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, presupuestoService, detalle, Upload){
    
    var ctrl = this;
    //console.log(detalle);
    
	presupuestoService.articulosProveedor({codigoproveedor:detalle.codigoproveedor, codigoempresa: detalle.codigoempresa}).then(function success(response)
    {
      ctrl.lista_articulos = response.data;
      ctrl.total = 0;
      _.each(ctrl.lista_articulos, function (obj, i)
        {
          obj.unidades = parseInt(obj.unidades);
          obj.poriva = parseInt(obj.poriva)
          obj.importedescuento = parseFloat(obj.importedescuento);
          obj.importeliquido = parseFloat(obj.importeliquido);
          obj.totaliva = parseFloat(obj.totaliva);
          obj.fechalinea = moment(obj.fechalinea).format("DD/MM/YYYY");
          ctrl.total += parseFloat(obj.importebruto);
        });

      
    },
      function error(response){
          toastr.info('No se han cargado los artículos');
          return '';
    });

  
    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);