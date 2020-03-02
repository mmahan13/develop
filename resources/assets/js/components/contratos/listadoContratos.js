import {erp} from '../../app.js'

erp.component('listadoContratos',{
  templateUrl: 'contratos-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','contratosService','FileSaver', 'moment','exportXlsx',
   function contratosController($rootScope, $scope, $uibModal, $filter, toastr, contratosService, FileSaver, moment, exportXlsx){
    
    var ctrl = this;
  
    ctrl.listarContratos = function() 
    {
      contratosService.contratos().then(function success(response)
  	  {
  	      ctrl.contratos = response.data;
          _.each(ctrl.contratos, function (obj, i)
          {
            obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
            obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
            obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
          });
      },function error(response){
    	          toastr.info('No se han cargado los contratos');
    	          return '';
   	    });
    }
  
   
    ctrl.datosContratos = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'datos-contrato-modal.html',
                controller: 'datosContratoModalController',
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
                        //let data = response;
                        //data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                        //ctrl.lista_clientes.unshift(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.nuevoContrato = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'nuevo-contrato-modal.html',
                controller: 'nuevoContratoModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                /*resolve: {
                    detalle: function()
                    {  
                      return row;
                    }
                }*/
              
            }).result.then((response) => { 
                if (response != null)
                {
                    let data = response;
                    console.log(data);
                    data[0].fechacontrato = moment(data[0].fechacontrato).format('DD/MM/YYYY');
                    data[0].fechaactivacion = moment(data[0].fechaactivacion).format('DD/MM/YYYY');
                    data[0].fechafinal = moment(data[0].fechafinal).format('DD/MM/YYYY');
                    ctrl.contratos.unshift(data[0]);
                }
            },
            function ()
            {
                // dismiss
            });
    }


    ctrl.exportarListadoContratos = function (filas) 
    {
      let data = [];
      _.each(filas, function (obj, i)
      {
           data[i] =  {
                Fecha_activación: obj.fechaactivacion,
                Fecha_inicio: obj.fechacontrato,
                Fecha_final: obj.fechafinal, 
                Contrato: obj.numerocontrato,
                Cliente: obj.razonsocial, 
                CIF:obj.cifdni, 
                Pago:obj.periodicidad,
                Impt_plan:parseFloat(obj.importehistorico).toFixed(2),
                Impt_anual:parseFloat(obj.importeanual).toFixed(2),
                Impt_bruto:parseFloat(obj.importenetolineas).toFixed(2),
                Porcentaje_descuento:parseInt(obj.pordescuento) | 0,
                Impt_descuento:parseFloat(obj.importedescuento).toFixed(2),
                Base_imponible:parseFloat(obj.importeneto).toFixed(2),
                Total_iva:parseFloat(obj.totaliva).toFixed(2),
                Total:parseFloat(obj.importeliquido).toFixed(2),
              };
      }); 
      exportXlsx.exportXlsxFile(data, 'listado_contratos');
    };


    $scope.$on('left_menu_selection', function (event, data) 
    { 
      if (data == 'listado_contratos') 
      {
          ctrl.listarContratos();
    
      }
    });

    $rootScope.$on('en_cabecera_activo', function (event, data) 
    { 
      if (angular.isObject(data)) 
      {
        console.log(data);
          _.each(ctrl.contratos, function (obj, i)
          {
            if(obj.idcontrato == data.idcontrato)
            {
              obj.fechacontrato = moment(data.fechacontrato).format('DD/MM/YYYY');
              obj.estado = data.estado;
            }
          });
    
      }
    });

    $rootScope.$on('en_cabecera_renueva', function (event, data) 
    { 
      if (angular.isObject(data)) 
      {
        _.each(ctrl.contratos, function (obj, i)
        {
            if(obj.idcontrato == data.idcontrato)
            {
              obj.renueva = data.renueva;
            }
        });
    
      }
    });

    $rootScope.$on('actualizar_listado_cabecera', function (event, data) 
    { 
      if (angular.isObject(data)) 
      {
        ctrl.listarContratos();
      }
    });

     $rootScope.$on('fechaactivacion_tabla', function(event, data){
      _.each(ctrl.contratos, function (obj, i)
        {
          if(obj.idcontrato == data.idcontrato){
            obj.fechaactivacion = data.fechaactivacion;
          }
           
        });
     });

  }]
});
