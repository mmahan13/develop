import {erp} from '../../app.js'

erp.component('nuevoPresupuesto',{
  templateUrl: 'nuevo-presupuesto-template.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','clientes', 'articulos', 'FileSaver', 'moment', 'presupuestoService',
   function nuevoPresupuestoController($rootScope, $scope, $uibModal, $filter, toastr, clientes, articulos, FileSaver, moment, presupuestoService){
    var ctrl = this;
    
    
    ctrl.cambiarFecha = moment(new Date()).format("DD/MM/YYYY");

    $rootScope.$on('nuevaFechaPresupuesto', function(event, data){
      ctrl.fecha = data.fecha;
    })

    ctrl.fecha = ctrl.cambiarFecha; 
  

    ctrl.iniciarLLamadas = function() 
    {
      ctrl.show_articulo = false;
      ctrl.show_cabecera = true;


      presupuestoService.getListaProveedores().then(function success(response)
      {
          ctrl.lista_proveedores = response.data;
          _.each(ctrl.lista_proveedores, function (obj, i)
            {
                obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
            });
      },function error(response){
                toastr.info('No se han cargado los datos de proveedores');
                return '';
      });

      presupuestoService.getCabeceraIvas().then(function success(response)
      {
          ctrl.datos = response.data;
          ctrl.tipo_factura =ctrl.datos.tipoFactura[0].tipo;
          
          ctrl.estado = {};
          ctrl.datos.tipoFactura;
          ctrl.estado.tipo = ctrl.datos.tipoFactura[0];
         
      },function error(response){
                toastr.info('No hay datos tipo factura');
                return '';
      });

        articulos.getArticulosObsoletoNo().then(function success(response)
        {
            ctrl.articulos = response.data;
            _.each(ctrl.articulos, function (obj, i)
            {
                obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
                obj.preciocompra = parseFloat(obj.preciocompra).toFixed(2) | parseFloat(0.00).toFixed(2);
            });
        },
          function error(response){
              toastr.info('No se han cargado los artículos');
              return '';
        });

 
	   
    };

   $scope.$broadcast('angucomplete-alt:changeInput', 'proveedor_autocomplete', 
            _.find(ctrl.lista_proveedores , function(o) { return o.codigoproveedor == row.codigoproveedor}));
      ctrl.ver_cif = false;
      ctrl.currentProveedor = function(row)
      {  
 
        return function (selected){
          if (angular.isDefined(selected))
          { 
            ctrl.ver_cif = true;
            row.razonsocial = selected.originalObject.razonsocial;
            ctrl.cifdni = selected.originalObject.cifdni;
            ///row.idproveedor = selected.originalObject.idproveedor;
            ctrl.idproveedor = selected.originalObject.idproveedor;
            ctrl.porretencion = parseFloat(selected.originalObject.porretencion);
            ctrl.codigoempresa = selected.originalObject.codigoempresa;

           
          }
        }
      };

      /*ctrl.recargoequivalencia = 0;
      ctrl.c = 'silver';
      ctrl.recargoEquivalencia = function(recargoequivalencia)
      {
       
        if(recargoequivalencia == 0){
          ctrl.recargoequivalencia = 1;
          ctrl.c = 'green';
        }else{
          ctrl.recargoequivalencia = 0;
          ctrl.c = 'silver';
        }
              
      } */
      ctrl.hoja_factura = [
                {idproveedor:'', razonsocial:'', fecha:new Date(), serie:'', numero_factura:'', descripcion_factura:'', pordescuento:parseFloat(0), 
                baseiva:parseFloat(0), baseiva2:parseFloat(0), baseiva3:parseFloat(0), baseivaexento:parseFloat(0), porretencion:parseFloat(0),},
            ];
    
    /*$rootScope.$on('fechalinea', function(event, data){
        let index =  ctrl.hoja_factura.indexOf(data.value);
        ctrl.hoja_factura[index].fecha = data.fecha;
      
    })*/
    //ctrl.addlineacabecera = 0;
 
   
    /*$scope.$watch('$lCtrl.hoja_factura', function(newCollection, oldCollection){
      
      _.each(newCollection, function (o, i)
      {
        o.porretencion = ctrl.porretencion;
      });
     /* if(ctrl.addlineacabecera > 0){
      ctrl.hoja_factura.push({idproveedor:'', razonsocial:'', fecha:moment(new Date()).format("DD/MM/YYYY"), serie:'', numero_factura:'', descripcion_factura:'', importe_neto:parseFloat(0), cuota_iva:parseFloat(0), cuota_iva2:parseFloat(0), cuota_iva3:parseFloat(0)});
      ctrl.addlineacabecera = 0;
    }
      
    }, true);*/

    
    ctrl.aniadirFactura = function($event, tipogasto)
    {
      if(parseInt(tipogasto) != 6)
      {

          if(ctrl.hoja[0].liquido == 0)
          {
            
              if(ctrl.idproveedor == undefined){
                toastr.info('Debe seleccionar un proveedor');
                return false;
              }

              if(ctrl.hoja_factura[0].pordescuento > 100){
                toastr.info('Desc % no puede superar el 100%');
                return false;
              }

              if(ctrl.porretencion > 100){
                toastr.info('Retención no puede superar el 100%');
                return false;
              }

              if(ctrl.hoja_factura[0].numero_factura == ''){
                toastr.info('Rellene el número de factura');
                return false;
              }
               
              if(ctrl.hoja_factura[0].baseiva == '' && ctrl.hoja_factura[0].baseiva2 == '' && ctrl.hoja_factura[0].baseiva3 == '' && ctrl.hoja_factura[0].baseivaexento == ''){
                toastr.info('Rellene almenos un campo Base');
                return false;
              }
            
            ctrl.cabeceraFactura = [];
            _.each(ctrl.hoja_factura, function (o, i)
            {
              o.idproveedor = ctrl.idproveedor;
              o.fecha_formateada = moment(o.fecha).format("YYYYMMDD");
              o.tipofactura = ctrl.estado.tipo.id;
              o.porretencion = ctrl.porretencion | 0;

              ctrl.cabeceraFactura.push(o);

            });
          
            
            presupuestoService.guardarCabeceraFactura(ctrl.cabeceraFactura).then(function success(response)
            {
              toastr.success('Factura proveedor generada correctamente');
              //ctrl.datos = response.data;
              $scope.$broadcast('angucomplete-alt:clearInput');
              ctrl.hoja_factura = [
              {idproveedor:'', razonsocial:'', fecha:new Date(), serie:'', numero_factura:'', descripcion_factura:'', pordescuento:parseFloat(0), 
                baseiva:parseFloat(0), baseiva2:parseFloat(0), baseiva3:parseFloat(0), baseivaexento:parseFloat(0), porretencion:parseFloat(0),},
              ];
              ctrl.porretencion = 0;
              ctrl.estado.tipo = ctrl.datos.tipoFactura[0];
              ctrl.c = 'silver';
              
            },function error(response){
                    toastr.info('Error al guardar');
                    return '';
            });

          }

          if(ctrl.hoja[0].liquido > 0)
          {
                if(ctrl.idproveedor == undefined){
                    toastr.info('Debe seleccionar un proveedor');
                    return false;
                  }

                  if(ctrl.hoja_factura[0].pordescuento > 100){
                    toastr.info('Desc % no puede superar el 100%');
                    return false;
                  }

                  if(ctrl.porretencion > 100){
                    toastr.info('Retención no puede superar el 100%');
                    return false;
                  }

                  if(ctrl.hoja_factura[0].numero_factura == ''){
                    toastr.info('Rellene número de factura');
                    return false;
                  }
                
                  ctrl.cabeceraPresupuesto = [];
                  _.each(ctrl.hoja_factura, function(o,i)
                  { 
                    o.idproveedor = ctrl.idproveedor;
                    o.fecha_formateada = moment(o.fecha).format("YYYYMMDD");
                    o.tipofactura = ctrl.estado.tipo | 0;
                    ctrl.cabeceraPresupuesto.push(o);
                  });
                  
                  ctrl.lineasPresupuesto = [];
                  _.each(ctrl.hoja, function (o, i)
                  {
                    if(o.descripcionarticulo != '' && o.liquido > 0 && o.preciocompra > 0){
                      ctrl.lineasPresupuesto.push(o);
                    }
                  });
                  
                  let datos = {
                    cabecera:ctrl.cabeceraPresupuesto,
                    articulos: ctrl.lineasPresupuesto,
                  };
                
                  presupuestoService.guardarFacturaConArticulos(datos).then(function success(response)
                  {
                    toastr.success('Factura proveedor generada correctamente');
                    ctrl.cabecera_presupuesto = response.data;
                      
                    $scope.$broadcast('angucomplete-alt:clearInput');
                      
                    ctrl.hoja_factura = [
                        {idproveedor:'', razonsocial:'', fecha:new Date(), serie:'', numero_factura:'', descripcion_factura:'', 
                          importe_neto:parseFloat(0), cuota_iva:parseFloat(0), cuota_iva2:parseFloat(0), cuota_iva3:parseFloat(0)},
                    ];

                    ctrl.hoja = [
                        {descripcionarticulo:'', descripcionlinea:'', cantidad:0, preciocompra:0, descuento:0, porcentaje:'', liquido:0},
                    ];

                    ctrl.totales_por_iva = [];
                      
                  },function error(response){
                          toastr.info('No se ha guardado la factura');
                          return '';
                    });
          }

      }
      if(parseInt(tipogasto) == 6)
      {
          
              if(ctrl.idproveedor == undefined){
              toastr.info('Debe seleccionar un proveedor');
              return false;
              }

              ctrl.cabeceraFactura = [];
              _.each(ctrl.hoja_factura, function (o, i)
              {
                o.idproveedor = ctrl.idproveedor;
                o.fecha_formateada = moment(o.fecha).format("YYYYMMDD");
                o.tipofactura = ctrl.estado.tipo.id;
                o.porretencion = 0;

                ctrl.cabeceraFactura.push(o);

              });
            
              
              presupuestoService.guardarCabeceraFactura(ctrl.cabeceraFactura).then(function success(response)
              {
                toastr.success('Gasto guardado');
                //ctrl.datos = response.data;
                $scope.$broadcast('angucomplete-alt:clearInput');
                ctrl.hoja_factura = [
                {idproveedor:'', razonsocial:'', fecha:new Date(), serie:'', numero_factura:'', descripcion_factura:'', pordescuento:parseFloat(0), 
                  baseiva:parseFloat(0), baseiva2:parseFloat(0), baseiva3:parseFloat(0), baseivaexento:parseFloat(0), porretencion:parseFloat(0),},
                ];
                ctrl.porretencion = 0;
                ctrl.c = 'silver';
                ctrl.estado.tipo = ctrl.datos.tipoFactura[0];
                ctrl.nogasto = true;
              },function error(response){
                      toastr.info('Error al guardar');
                      return '';
              }); 
            
      }
    };



    $scope.$broadcast('angucomplete-alt:changeInput', 'articulo_autocomplete', 
          _.find(ctrl.articulos , function(o) { return o.codigoarticulo == row.codigoarticulo}));
  
    ctrl.currentArticulo = function(row)
    {  
          //con esta funcion consigo la row de la tabla para añadir estos dos valores
           return function (selected) {
              if (angular.isDefined(selected))
              {  
                row.descripcionarticulo = selected.description.descripcionarticulo;
                row.descripcionlinea = selected.description.descripcionlinea;
                row.codigoarticulo = parseInt(selected.description.codigoarticulo);
                row.porcentaje = parseInt(selected.description.porcentaje) | 0;
                row.preciocompra = parseFloat(selected.description.preciocompra) | 0;
                row.tipoiva = selected.description.tipoiva;
                ctrl.preciocompra = row.preciocompra;

              }  
            }
        
    };
     

    ctrl.hoja = [
        {descripcionarticulo:'', descripcionlinea:'', cantidad:(angular.isDefined(ctrl.preciocompra))?1:0, preciocompra:ctrl.preciocompra | 0.00,
         descuento:0, porcentaje:'', liquido:0},
        //{descripcionarticulo:'', comentario:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', liquido:''},
        //{descripcionarticulo:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', importe:''},
    ];

   
    ctrl.addlinea = 0;
    $scope.$watch('$lCtrl.hoja', function(newCollection, oldCollection) {
    
    _.each(newCollection, function (o, i)
    {
      o.bruto = (parseFloat(o.cantidad)*parseFloat(o.preciocompra));
      //o.bruto =(parseFloat(o.cantidad)*parseFloat(o.preciocompra)*o.descuento/100);
      o.desc = (parseFloat(o.cantidad)*parseFloat(o.preciocompra)*o.descuento/100);
      o.valor = (o.bruto - o.desc);
      o.liquido = parseFloat(o.valor);
      ctrl.addlinea = o.liquido;

    });

    if(ctrl.addlinea > 0){
      ctrl.hoja.push({descripcionarticulo:'', descripcionlinea:'', cantidad:0, preciocompra:0, descuento:0, porcentaje:'', liquido:0});
      ctrl.addlinea = 0;
    }

      ctrl.total_importe_general = 0;
      ctrl.total_importe_reducido = 0;
      ctrl.total_importe_super_reducido = 0;
      ctrl.exento_iva = 0;

      ctrl.total_iva_general= 0;
      ctrl.total_iva_reducido= 0;
      ctrl.total_iva_super_reducido= 0;
    
      _.each(ctrl.hoja, function (o, i)
      {
        if(parseInt(o.porcentaje) == 21)
        {
          ctrl.total_importe_general += o.liquido;
          ctrl.total_iva_general = (ctrl.total_importe_general*parseInt(o.porcentaje)/100);
          ctrl.iva_general = o.porcentaje;
          ctrl.tipo_iva_general = o.tipoiva;
        }
        if(parseInt(o.porcentaje) ==10)
        {
          ctrl.total_importe_reducido += o.liquido;
          ctrl.total_iva_reducido = (ctrl.total_importe_reducido*parseInt(o.porcentaje)/100);
          ctrl.iva_reducido = o.porcentaje;
          ctrl.tipo_iva_reducido = o.tipoiva;
        }
        if(parseInt(o.porcentaje) ==4)
        {
          ctrl.total_importe_super_reducido += o.liquido;
          ctrl.total_iva_super_reducido = (ctrl.total_importe_super_reducido*parseInt(o.porcentaje)/100);
          ctrl.iva_super_reducido = o.porcentaje;
          ctrl.tipo_iva_super_reducido = o.tipoiva;
        }
        if(parseInt(o.porcentaje) == 0)
        {
          ctrl.exento_iva += o.liquido;
          ctrl.total_iva_exento = 0;
          ctrl.iva_exento = 0;
          ctrl.tipo_iva_exento = o.tipoiva;
        }
      });
      
    ctrl.totales_por_iva = [];
    ctrl.totales_por_iva.push({total_importe: ctrl.total_importe_general, total_iva: ctrl.total_iva_general, porcentaje: ctrl.iva_general, tipoiva:ctrl.tipo_iva_general});
    ctrl.totales_por_iva.push({total_importe: ctrl.total_importe_reducido, total_iva: ctrl.total_iva_reducido, porcentaje: ctrl.iva_reducido, tipoiva:ctrl.tipo_iva_reducido});
    ctrl.totales_por_iva.push({total_importe: ctrl.total_importe_super_reducido, total_iva: ctrl.total_iva_super_reducido, porcentaje: ctrl.iva_super_reducido, tipoiva: ctrl.tipo_iva_super_reducido});
    ctrl.totales_por_iva.push({total_importe: ctrl.exento_iva, total_iva: ctrl.total_iva_exento, porcentaje: ctrl.iva_exento, tipoiva:ctrl.tipo_iva_exento});
    
    ctrl.base_imponible = parseFloat(0);
    ctrl.bruto = parseFloat(0);
    _.each(ctrl.hoja, function (o, i)
    {
      ctrl.bruto += o.bruto;
      ctrl.base_imponible += parseFloat(o.liquido);
    });

    ctrl.totalIVA = (ctrl.total_iva_general+ctrl.total_iva_reducido+ctrl.total_iva_super_reducido);
    ctrl.total_factura = (ctrl.base_imponible + ctrl.totalIVA);
  
  }, true);
   
    ctrl.addList = function($event)
    {
       ctrl.hoja.push({descripcionarticulo:'', descripcionlinea:'', cantidad:0, preciocompra:0, descuento:0, porcentaje:'', liquido:0});
    }; 

    ctrl.removeRow = function (row){
        var index =  ctrl.hoja.indexOf(row);
        if (index !== -1) {
            ctrl.hoja.splice(index, 1);
        }
    }

    ctrl.removeRowFactura = function (row){
        var index = ctrl.hoja_factura.indexOf(row);
        if (index !== -1) {
            ctrl.hoja_factura.splice(index, 1);
        }
    }



    ctrl.generarNuevaFactura = function($event)
    {
      
      if(ctrl.total_factura == 0){
        toastr.info('No se puede crear una factura con total 0');
        return false;
      }
      
      if(ctrl.idproveedor == undefined){
        toastr.info('Debe seleccionar un proveedor');
        return false;
      }

      if(ctrl.hoja_factura[0].pordescuento > 100){
        toastr.info('Desc % no puede superar el 100%');
        return false;
      }

      if(ctrl.porretencion > 100){
        toastr.info('Retención no puede superar el 100%');
        return false;
      }

      if(ctrl.hoja_factura[0].numero_factura == ''){
        toastr.info('Rellene número de factura');
        return false;
      }
    
      ctrl.cabeceraPresupuesto = [];
      _.each(ctrl.hoja_factura, function(o,i)
      { 
        o.idproveedor = ctrl.idproveedor;
        o.fecha_formateada = moment(o.fecha).format("YYYYMMDD");
        o.recargoequivalencia = ctrl.recargoequivalencia | 0;
        o.tipofactura = ctrl.estado.tipo | 0;
        ctrl.cabeceraPresupuesto.push(o);
      });
      
      ctrl.lineasPresupuesto = [];
      _.each(ctrl.hoja, function (o, i)
      {
        if(o.descripcionarticulo != '' && o.liquido > 0 && o.preciocompra > 0){
          ctrl.lineasPresupuesto.push(o);
        }
      });
      

      let datos = {
        cabecera:ctrl.cabeceraPresupuesto,
        articulos: ctrl.lineasPresupuesto,
      };
    
      presupuestoService.guardarPresupuesto(datos).then(function success(response)
      {
        toastr.success('Factura proveedor generada correctamente');
        ctrl.cabecera_presupuesto = response.data;
        console.log(ctrl.cabecera_presupuesto);
          
        $scope.$broadcast('angucomplete-alt:clearInput');
          
        ctrl.hoja_factura = [
            {idproveedor:'', razonsocial:'', fecha:new Date(), serie:'', numero_factura:'', descripcion_factura:'', 
              importe_neto:parseFloat(0), cuota_iva:parseFloat(0), cuota_iva2:parseFloat(0), cuota_iva3:parseFloat(0)},
        ];

        ctrl.hoja = [
            {descripcionarticulo:'', descripcionlinea:'', cantidad:0, preciocompra:0, descuento:0, porcentaje:'', liquido:0},
        ];

        ctrl.totales_por_iva = [];
          
        
           
      },function error(response){
              toastr.info('Algo no ha ido bien');
              return '';
        }); 

    };


    $scope.$on('left_menu_selection', function (event, data) 
    { 
           listado_facturas_proveedores
        if (data == 'nuevo_presupuesto') 
        {
            ctrl.iniciarLLamadas();
      
        }
    });


    ctrl.addcomentario = function($event, row)
    { 
        $event.stopImmediatePropagation();
        $event.preventDefault();
  
        $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'comentario-modal.html',
                controller: 'comentarioModalController',
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
                      var index = ctrl.hoja.indexOf(response);
                      ctrl.hoja[index].descripcionlinea = response.descripcionlinea;

                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.lineas = true;
    ctrl.cabecera = false;
    ctrl.cambiar_a_lineas = function($event)
    {
        ctrl.show_articulo = true;
        ctrl.show_cabecera = false;
        ctrl.lineas = false;
        ctrl.cabecera = true;
    }
    ctrl.cambiar_a_cabecera = function($event)
    {
        ctrl.show_articulo = false;
        ctrl.show_cabecera = true;
        ctrl.lineas = true;
        ctrl.cabecera = false;
    }

    ctrl.nogasto = true;
    ctrl.cambiarTipoFactura = function(tipofactura)
    {
      if(parseInt(tipofactura) == 6){
        ctrl.nogasto = false;
      }
      if(parseInt(tipofactura) != 6){
        ctrl.nogasto = true;
      }
    }

  }]
});
