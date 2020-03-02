import {erp} from '../../app.js'

erp.component('listaEmpresas',{
  templateUrl: 'lista-empresas-table.html', 
 /*bindings:{ eventosVacaciones : '<',
             eventosComercial : '<',
           },*/
  controllerAs:'$lCtrl',
  
  controller:['$rootScope','$scope','$uibModal', '$filter', 'toastr','empresas','FileSaver', 'moment',
   function listaEmpresaController($rootScope, $scope, $uibModal, $filter, toastr, empresas, FileSaver, moment){
    var ctrl = this;
  
    this.$onInit = function() 
    {

		empresas.getListaEmpresas().then(function success(response)
    {
        ctrl.lista_empresas = response.data;
        //console.log(ctrl.lista_empresas);
        _.each(ctrl.lista_empresas, function (obj, i)
        {
           	obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
        });
    },
      function error(response){
          toastr.info('No se han cargado datos de ventas');
          return '';
    });

	   
    };
        
     
   

    ctrl.nuevoEmpresa = function($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'nueva-empresa-modal.html',
                controller: 'nuevaEmpresaModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                     	//return ctrl.lista_clientes;
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        //data.fechaalta = moment(data.fechaalta).format("DD/MM/YYYY");
                        ctrl.lista_empresas.unshift(data);
                        
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    /*ctrl.fichaCliente = function($event, row)
    {
      $event.stopImmediatePropagation();
      $event.preventDefault();
      
       $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'ficha-cliente-modal.html',
                controller: 'fichaClienteModalController',
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
                        let data = response;
                        ctrl.lista_clientes = data;
                        _.each(ctrl.lista_clientes, function (obj, i)
				        {
				           obj.fechaalta = moment(obj.fechaalta).format("DD/MM/YYYY");
				            //moment($scope.newParteEnCurso.hora_llegada).format("HH:mm");
				        });

                        
                    }
                },
                function ()
                {
                    // dismiss
                });
     

    };
  
     */

     



  }]
});
