import {erp} from '../../app.js';

erp.controller('editarArticuloModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','articulos', 'detalle',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, articulos, detalle){
    
    var ctrl = this;
    console.log(detalle);
    articulos.getIvas().then(function (response)
    {
      
        ctrl.ivas = {};
        ctrl.Tipos = response.data;
        _.each(ctrl.Tipos, function (obj, i)
              {
                if(detalle.id_iva === obj.id)
                {
                  ctrl.ivas.poriva = obj;
                }
              });
    });

    ctrl.id = detalle.id;
    ctrl.ref = detalle.ref;
    ctrl.producto = detalle.producto;
    
  
    ctrl.actualizarArticulo = function($event)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
      let data = {
        id:  ctrl.id,
        ref: ctrl.ref,
        producto: ctrl.producto.toUpperCase(),
        id_iva: ctrl.ivas.poriva.id,
      }

     
      articulos.editarArticulo(data).then(function (response){
          toastr.success('Editado Correctamente');
          $uibModalInstance.close(response.data);
          
      },function error(response){
        toastr.info('Error al editar el producto');
        return '';
      });

    }

  
      ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
    }
]);