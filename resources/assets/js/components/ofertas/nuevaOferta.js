import {erp} from '../../app.js'

erp.component('nuevaOferta',{
  templateUrl: 'nueva-oferta-cuerpo.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','clientes','FileSaver', 'moment','articulos','ofertasService',
   function nuevaOfertaController($rootScope, $scope, $uibModal, $filter, toastr, clientes, FileSaver, moment,articulos, ofertasService){
    var ctrl = this;

    ctrl.pordescuento = 0;
    ctrl.porretencion = 0;
    ctrl.fecha = new Date();

    ctrl.nuevaOfertaLlamadas = function() 
    {
        
        ofertasService.numeroOferta().then(function success(response)
        {
            ctrl.numero_oferta = response.data;
            ctrl.numero_oferta[0].numerooferta = ctrl.numero_oferta[0].contador;
           
        },
          function error(response){
              toastr.info("No hay número oferta");
              return '';
        });

  		clientes.getListaClientes().then(function success(response)
	    {
	        ctrl.lista_clientes = response.data;
          
	    },function error(response){
  	          toastr.info('No hay registro de clientes');
  	          return '';
  	    });

    };

    $scope.$broadcast('angucomplete-alt:changeInput', 'cliente_autocomplete', 
            _.find(ctrl.lista_clientes , function(o) { return o.codigocliente == row.codigocliente}));
     
      ctrl.currentCliente = function(cliente_autocomplete)
      {  
        if (angular.isDefined(cliente_autocomplete))
        { 
          
          ctrl.razonsocial = cliente_autocomplete.originalObject.razonsocial;
          ctrl.codigocliente = cliente_autocomplete.originalObject.codigocliente;
          ctrl.idcliente = cliente_autocomplete.originalObject.idcliente;
          ctrl.codigoempresa = cliente_autocomplete.originalObject.codigoempresa;
          ctrl.porretencion = parseFloat(cliente_autocomplete.originalObject.porretencion) | 0;
          ctrl.tarifaprecio = parseFloat(cliente_autocomplete.originalObject.tarifaprecio);


          articulos.getArticulosSegunTarifaPrecio({tarifaprecio:ctrl.tarifaprecio}).then(function success(response)
          {
              ctrl.articulos = response.data;
              //console.log(ctrl.articulos)
              _.each(ctrl.articulos, function (obj, i)
              {
                  obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
              });
          },
            function error(response){
                toastr.info('No hay datos de artículos');
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
                row.precioventa = parseFloat(selected.description.precioventa) | 0;
                row.tipoiva = selected.description.tipoiva;
              }  
            }
        
    };


    ctrl.hoja = [
        {descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0},
        //{descripcionarticulo:'', comentario:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', liquido:''},
    ];

    ctrl.pordescuento_total = 0;
    $scope.$watch('$lCtrl.porretencion', function(newvalue, o) 
    {
      ctrl.porretencion = newvalue;
     
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
    ctrl.serieoferta = '';
   
  
    $scope.$watch('$lCtrl.porretencion', function(newvalue, o) 
    {
      ctrl.formporretencion = false;
      ctrl.porretencion = newvalue;
      if(ctrl.porretencion > 100){
        ctrl.formporretencion = true;
        
      }
    });  

    $scope.$watch('$lCtrl.pordescuento', function(newvalue, o) 
    {
      ctrl.formpordescuento = false;
      ctrl.pordescuento = newvalue;
      if(ctrl.pordescuento > 100){
        ctrl.formpordescuento = true;
       
      }
      
    });  

    $scope.$watch('$lCtrl.serieoferta', function(newvalue, o) 
    {
      ctrl.formserieoferta = false;
      ctrl.serieoferta = newvalue;
      if(ctrl.serieoferta.length > 20)
      {
          ctrl.formserieoferta = true;
      }
      
    });  
    
    ctrl.generarNuevaOferta = function($event)
    {
      ctrl.formserieoferta = false;
      ctrl.formporretencion = false;
      ctrl.formpordescuento = false;
      
      if(ctrl.total_factura == 0){
        toastr.info('total de la oferta no puede ser 0');
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
      if(ctrl.serieoferta.length > 20)
      {
        ctrl.formserieoferta = true;
        return false;
      }

      
      
      ctrl.lineas_ofertas = [];
      _.each(ctrl.hoja, function (o, i)
      {
        if(o.descripcionarticulo != '' && o.liquido > 0 && o.precioventa > 0){
          ctrl.lineas_ofertas.push(o);
        }
      });

      let datos = {
        serieoferta : ctrl.serieoferta,
        numerooferta: ctrl.numero_oferta[0].numerooferta,
        idcliente: ctrl.idcliente,
        fecha: moment(ctrl.fecha).format("YYYYMMDD"),
        descripcionoferta:ctrl.observaciones,
        pordescuento: ctrl.pordescuento | 0,
        porretencion: ctrl.porretencion,
        tipooferta:ctrl.estado.tipo.id | 1,
        articulos: ctrl.lineas_ofertas,
      };
    
    
    ofertasService.generarOferta(datos).then(function success(response)
    {
        toastr.success('Oferta generada');
        ctrl.cabecera_oferta = response.data;
        
        $scope.$broadcast('angucomplete-alt:clearInput');
        ctrl.formserieoferta = false;
        ctrl.razonsocial = '';
        ctrl.serieoferta = '';
        ctrl.fecha = new Date();
        ctrl.observaciones = '';
        ctrl.porretencion = 0;
        ctrl.pordescuento = 0;
        ctrl.importesubtotal = 0;
        ctrl.estado.tipo = 1;
        ctrl.hoja = [
        {descripcionarticulo:'', descripcionlinea:'', cantidad:0, precioventa:0, descuento:0, porcentaje:'', liquido:0},
        //{descripcionarticulo:'', comentario:'', cantidad:'', precioventa:'', descuento:'', porcentaje:'', liquido:''},
        ];
        ctrl.totales_por_iva = [];

        /*ofertasService.getDatosNuevaFactura().then(function success(response)
        {
            ctrl.datos_nueva_factura = response.data;
            ctrl.datos_nueva_factura[0].numerofactura = ctrl.datos_nueva_factura[0].contador;
           
        },
          function error(response){
              toastr.info("No hay número factura");
              return '';
        });*/
         
    },function error(response){
            toastr.info('No se ha guardado la factura');
            return '';
      });

    };

    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'nueva_oferta') 
      {
        ctrl.nuevaOfertaLlamadas();
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


