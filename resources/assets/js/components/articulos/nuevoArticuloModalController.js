import {erp} from '../../app.js';

erp.controller('nuevoArticuloModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','articulos',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, articulos){
    
    var ctrl = this;

    articulos.getIvas().then(function (response)
    {
        ctrl.ivas = {};
        ctrl.Tipos = response.data;
        ctrl.ivas.poriva = ctrl.Tipos[2];
    });

  
    ctrl.guardarArticulo = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
      let datos = {
        ref: ctrl.ref,
        producto: ctrl.producto.toUpperCase(),
        id: ctrl.ivas.poriva.id,
      }
      
      articulos.nuevoProducto(datos).then(function (response){
          toastr.success('Producto añadido');
          $uibModalInstance.close(response.data);
      },function error(response){
          toastr.info('Error al crear el producto');
          return '';
    });

    }

  
      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);