import {erp} from '../../app.js'

erp.component('nuevaFactura',{
  templateUrl: 'nueva-factura-crear.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','clientes','FileSaver', 'moment','articulos','facturaService','usuariosService',
   function listaClientesFacturarController($rootScope, $scope, $uibModal, $filter, toastr, clientes, FileSaver, moment,articulos, facturaService,
    usuariosService){
    var ctrl = this;

    ctrl.pordescuento = 0;
    ctrl.porretencion = 0;
    ctrl.fecha = new Date();

    
    ctrl.nuevaFacturaLlamadas = function() 
    {
      
        facturaService.numeroFactura().then(function success(response)
        {
          ctrl.seriefactura = parseInt(response.data[0]);
          ctrl.numerofactura = response.data[1];
        },
          function error(response){
              toastr.info("No hay número factura");
              return '';
        });

      usuariosService.listarUsuarios().then(function success(response)
	    {
          ctrl.lista_clientes = response.data;
      },
      function error(response){
  	          toastr.info('No hay registro de clientes');
  	          return '';
  	    });

     
      usuariosService.getProductos().then(function success(response)
      {
          ctrl.productos = response.data;
      },
      function error(response){
            toastr.info('No se han cargado los productos');
            return '';
      });

    };

    $scope.$broadcast('angucomplete-alt:changeInput', 'cliente_autocomplete',_.find(ctrl.lista_clientes , function(o){ return o.id == row.id}));
     
      ctrl.currentCliente = function(cliente_autocomplete)
      {  
        if (angular.isDefined(cliente_autocomplete))
        { 
          ctrl.nombre = cliente_autocomplete.originalObject.nombre;
          ctrl.idcliente = cliente_autocomplete.originalObject.id;

        }
      };



    $scope.$broadcast('angucomplete-alt:changeInput', 'productos_autocomplete', 
          _.find(ctrl.productos , function(o) { return o.ref == row.ref}));
  
    ctrl.currentArticulo = function(row)
    {  
      //con esta funcion consigo la row de la tabla para añadir estos dos valores
        return function (selected) {
          if (angular.isDefined(selected))
          {  
            row.idarticulo = selected.description.id;
            row.descripcionarticulo = selected.description.producto;
            row.descripcionlinea = selected.description.descriptionlg;
            row.codigoarticulo = selected.description.ref;
            row.porcentaje = parseInt(selected.description.poriva) | 0;
            row.precioventa = parseFloat(selected.description.precioventa) | 0;
            row.tipoiva = selected.description.tipoiva;
          }  
        }
        
    };

   /* ctrl.recargoequivalencia = 0;
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

    ctrl.hoja = [
        {descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0},
        //{descripcionarticulo:'', comentario:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', liquido:''},
    ];

    ctrl.pordescuento_total = 0;
    
    $scope.$watch('$lCtrl.pordescuento', function(newvalor, o) 
    {
      ctrl.pordescuento_total= newvalor;
      
      ctrl.addlinea = 0;
      $scope.$watch('$lCtrl.hoja', function(newCollection, oldCollection) 
      {
          ctrl.formdescuento = false;
        _.each(newCollection, function (o, i)
        {
          if(o.descuento > 100){
            ctrl.formdescuento = true;
            return false;
          }
          o.bruto = (parseFloat(o.cantidad)*parseFloat(o.precioventa));
          o.desc = (parseFloat(o.cantidad)*parseFloat(o.precioventa)*o.descuento/100);
          o.valor = (o.bruto - o.desc);
          o.liquido = parseFloat(o.valor);
          ctrl.addlinea = o.liquido;
          o.descripcionlinea  = o.descripcionlinea;

        });

        if(ctrl.addlinea > 0){
          ctrl.hoja.push({descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0});
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
            if(parseInt(o.porcentaje) == 4)
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
        ctrl.totales_por_iva.push({total_importe: ctrl.exento_iva, total_iva: 0, porcentaje: ctrl.iva_exento, tipoiva:ctrl.tipo_iva_exento});
        
        ctrl.base_imponible = parseFloat(0);
        ctrl.importenetolienas = parseFloat(0);
        ctrl.descuentototalfactura = parseFloat(0);
        ctrl.total_factura = parseFloat(0);
        _.each(ctrl.hoja, function (o, i)
        {
          //ctrl.bruto += o.bruto;
          ctrl.importenetolienas += parseFloat(o.liquido);
          ctrl.base_imponible += parseFloat(o.liquido);
        });
        ctrl.totalIVA = 0;
        ctrl.totalIVA = (ctrl.total_iva_general+ctrl.total_iva_reducido+ctrl.total_iva_super_reducido);
        //ctrl.descuentototalfactura = (ctrl.base_imponible + ctrl.totalIVA) * parseInt(ctrl.descuentototal )/100;
        

        if(ctrl.pordescuento_total != 0)
        {
          ctrl.descuento_base_iva = 0;
          ctrl.totalIVA = 0;
          _.each(ctrl.totales_por_iva, function(obj,i)
           {
            if(obj.total_importe !=0 && obj.total_iva != 0 && angular.isDefined(obj.tipoiva) && angular.isDefined(obj.porcentaje))
            {
              ctrl.descuento_base_iva = (obj.total_importe * ctrl.pordescuento_total)/100;
              obj.total_importe = obj.total_importe - ctrl.descuento_base_iva;
              obj.total_iva = (obj.total_importe * obj.porcentaje)/100;
              ctrl.totalIVA += obj.total_iva;
            }
          });

            
        }
        ctrl.descuentototalfactura = (ctrl.base_imponible * parseInt(ctrl.pordescuento_total))/100;
        ctrl.base_imponible = ctrl.base_imponible - ctrl.descuentototalfactura;
        ctrl.importeretencion = (parseFloat(ctrl.porretencion) * parseFloat(ctrl.base_imponible))/100;
        if(ctrl.importeretencion > 0){
          ctrl.importesubtotal =  (parseFloat(ctrl.base_imponible) + parseFloat(ctrl.totalIVA));
        }
        ctrl.total_factura = (parseFloat(ctrl.base_imponible) + parseFloat(ctrl.totalIVA) - parseFloat(ctrl.importeretencion));
    
    }, true);

    });


   
    ctrl.addList = function($event)
    {
       ctrl.hoja.push({descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0});
    }; 

    ctrl.removeRow = function removeRow(row){
        var index =  ctrl.hoja.indexOf(row);
        if (index !== -1) {
            ctrl.hoja.splice(index, 1);
        }
    }

    ctrl.observaciones = '';
    ctrl.seriefactura = '';
   
  
    /*$scope.$watch('$lCtrl.porretencion', function(newvalue, o) 
    {
      ctrl.formporretencion = false;
      ctrl.porretencion = newvalue;
      if(ctrl.porretencion > 100){
        ctrl.formporretencion = true;
        
      }
    });  */

    $scope.$watch('$lCtrl.pordescuento', function(newvalue, o) 
    {
      ctrl.formpordescuento = false;
      ctrl.pordescuento = newvalue;
      if(ctrl.pordescuento > 100){
        ctrl.formpordescuento = true;
       
      }
      
    });  

    $scope.$watch('$lCtrl.seriefactura', function(newvalue, o) 
    {
      ctrl.formseriefactura = false;
      ctrl.seriefactura = newvalue;
      if(ctrl.seriefactura.length > 20)
      {
          ctrl.formseriefactura = true;
      }
      
    });  
    
    ctrl.generarNuevaFactura = function($event)
    {
      ctrl.formseriefactura = false;
      ctrl.formporretencion = false;
      ctrl.formpordescuento = false;
      
      if(ctrl.total_factura == 0){
        toastr.info('total de la factura no puede ser 0');
        return false;
      }
      if(ctrl.idcliente == undefined){
        toastr.info('Debe añadir un cliente');
        return false;
      }

      if(ctrl.pordescuento > 100){
        ctrl.formpordescuento = true;
        return false;
      }
       if(ctrl.porretencion > 100){
        ctrl.formporretencion = true;
        return false;
      }
      if(ctrl.seriefactura.length > 20)
      {
        ctrl.formseriefactura = true;
        return false;
      }

      
      ctrl.lineas_factura = [];
      _.each(ctrl.hoja, function (o, i)
      {
        if(o.descripcionarticulo != '' && o.liquido > 0 && o.precioventa > 0){
          ctrl.lineas_factura.push(o);
        }
      });

      let datos = {
        seriefactura : ctrl.seriefactura,
        numerofactura: ctrl.numerofactura,
        idcliente: ctrl.idcliente,
        fecha: moment(ctrl.fecha).format("YYYYMMDD"),
        observacionesfactura:ctrl.observaciones,
        pordescuento: ctrl.pordescuento | 0,
        descuentototalfactura: ctrl.descuentototalfactura.toFixed(2),
        importebruto: ctrl.importenetolienas,
        baseimponible: ctrl.base_imponible.toFixed(2),
        totaliva: ctrl.totalIVA.toFixed(2),
        importesubtotal: ctrl.importesubtotal,
        totalfactura: ctrl.total_factura.toFixed(2),
        articulos: ctrl.lineas_factura,
        totales_por_iva: ctrl.totales_por_iva
      };
      
    
    facturaService.facturar(datos).then(function success(response)
    {
        toastr.success('Factura generada correctamente');
      
        $scope.$broadcast('angucomplete-alt:clearInput');
        ctrl.formseriefactura = false;
        ctrl.descuento_total_factura = 0;
        ctrl.fecha = new Date();
        ctrl.observaciones = '';
        ctrl.porretencion = 0;
        ctrl.pordescuento = 0;
        ctrl.importesubtotal = 0;
        
        ctrl.hoja = [
        {descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0},
        ];
        ctrl.totales_por_iva = [];

        ctrl.nuevaFacturaLlamadas();
      
         
    },function error(response){
            console.log(response);
            toastr.info('No se ha guardado la factura');
            return '';
      });

    };

    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'nueva_factura') 
      {
        ctrl.nuevaFacturaLlamadas();
      }
    });

    
    ctrl.addcomentario = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
        if(row.descripcionarticulo == ''){
              toastr.info('Para comentar, debe primero añadir una descripción');
              return false;
        }
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
                      //console.log(index)
                      ctrl.hoja[index].comentario = response.comentario;
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    
    
  }]
});


/*
 

*/