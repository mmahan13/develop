import {erp} from '../../app.js';

erp.controller('addLineasContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','articulos',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, articulos){
    
    var ctrl = this;
    //console.log(detalle);
    
     articulos.getArticulosObsoletoNo().then(function success(response)
      {
          ctrl.articulos = response.data;
          //console.log(ctrl.articulos);
          _.each(ctrl.articulos, function (obj, i)
          {
              obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
          });
      },
        function error(response){
            toastr.info('No se han cargado datos de ventas');
            return '';
      });

    $scope.$broadcast('angucomplete-alt:changeInput', 'articulo_autocomplete', 
          _.find(ctrl.articulos , function(o) { return o.codigoarticulo == row.codigoarticulo}));
  
    ctrl.currentArticulo = function(row)
    {  
          //con esta funcion consigo la row de la tabla para añadir estos dos valores
          //console.log(row);
           return function (selected) {
              if (angular.isDefined(selected))
              {  
                row.descripcionarticulo = selected.description.descripcionarticulo;
                row.codigoarticulo = parseInt(selected.description.codigoarticulo);
                row.porcentaje = parseInt(selected.description.porcentaje) | 0;
                row.precioventa = parseFloat(selected.description.precioventa) | 0;
                row.tipoiva = selected.description.tipoiva;
                row.grupoiva = selected.description.grupoiva;
              }  
            }
        
    };

    ctrl.hoja = [
        {descripcionarticulo:'', comentario:'', unidades:0, precioventa:0, descuento:0, porcentaje:'', liquido:0, bajalinea:0},
        //{descripcionarticulo:'', comentario:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', liquido:''},
        //{descripcionarticulo:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', importe:''},
    ];

    
   
    ctrl.addlinea = 0;
    $scope.$watch('$ctrl.hoja', function(newCollection, oldCollection) {
    
    _.each(newCollection, function (o, i)
    {
      o.bruto = (parseFloat(o.unidades)*parseFloat(o.precioventa));
      o.desc = (parseFloat(o.unidades)*parseFloat(o.precioventa)*o.descuento/100);
      o.valor = (o.bruto - o.desc);
      o.liquido = parseFloat(o.valor);
      ctrl.addlinea = o.liquido;
    
    });

    if(ctrl.addlinea > 0){
      ctrl.hoja.push({descripcionarticulo:'', comentario:'', unidades:0, precioventa:0, descuento:0, porcentaje:'', liquido:0, bajalinea:0});
      ctrl.addlinea = 0;
    }

     
    ctrl.base_imponible = parseFloat(0);
    ctrl.total = parseFloat(0);
    _.each(ctrl.hoja, function (o, i) 
    {
      ctrl.total += o.bruto;
      ctrl.base_imponible += parseFloat(o.liquido);
    });

   
  }, true);

    ctrl.removeRow = function removeRow(row){
        var index =  ctrl.hoja.indexOf(row);
        if (index !== -1) {
            ctrl.hoja.splice(index, 1);
        }
    }
  
    ctrl.activarArticuloSiNo = function($event, row){
      $event.stopImmediatePropagation();
      $event.preventDefault();
      //console.log(row)
      row.bajalinea = row.bajalinea == 0 ? 1 : 0;

       
    }


    ctrl.guardarLinea = function () {
       $uibModalInstance.close(ctrl.hoja);
    };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);

                                                                                          