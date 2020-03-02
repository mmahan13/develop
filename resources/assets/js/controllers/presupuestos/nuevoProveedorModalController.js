import {erp} from '../../app.js';

erp.controller('nuevoProveedorModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle','Upload', 'presupuestoService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle, Upload, presupuestoService){
    
      var ctrl = this;


      clientes.getSigla().then(function success(response)
      {
        ctrl.tipovia = {};
        ctrl.via = response.data;
       //inicializo el option select
        ctrl.tipovia.sigla = ctrl.via[7];
        
      },
        function error(response){
            toastr.info('No se han cargado datos de ventas');
            return '';
      });

      

      $scope.$broadcast('angucomplete-alt:changeInput', 'cp_autocomplete', 
            _.find(ctrl.codigos_postales , function(o) { return o.codigopostalid == row.codigopostalid}));
     
      ctrl.currentProvincia = function(cp_autocomplete)
      {   
          ctrl.codigopostalid = cp_autocomplete.originalObject.codigopostalid;
          ctrl.poblacion = cp_autocomplete.originalObject.poblacion;
          console.log(ctrl.codigopostalid)
          console.log(ctrl. ctrl.poblacion)
          
      };

      

      

       ctrl.signature = {};
        ctrl.img = [];
        ctrl.guardar = false;

          ctrl.uploadFile = function (file, url, type){
            
            Upload.upload({
                url: url,
                data: {
                    file: file,
                    extension: angular.isDefined(file.name) ? file.name.split('.')[file.name.split('.').length - 1] : 'png'
                }
            }).then(function (resp) {
                switch (type) {
                    case 'png':
                        ctrl.logotipo = 'data:image/png;base64,' + resp.data;
                        break;
                    default:
                        ctrl.logotipo = 'data:image/jpg;base64,' + resp.data;
                        
                        //ctrl.img.push({logocliente:ctrl.logotipo});
                        //console.log(ctrl.logotipo);
                       
                        break;
                        
                }
                   let newProveedor = {
                      razonsocial: ctrl.razonsocial.toUpperCase(),
                      cifdni: ctrl.cifdni.toUpperCase(),
                      telefono: ctrl.telefono,
                      email1: ctrl.email1,
                      comentarios: ctrl.comentarios,
                      logoempresa: ctrl.logotipo,
                      codigosigla: ctrl.tipovia.sigla.codigosigla,
                      sigla: ctrl.tipovia.sigla.sigla,
                      direaccion: ctrl.direccion,
                      numero1: ctrl.numero1,
                      provinciaid: ctrl.provinciaid,
                      provincia: ctrl.provincia,
                      poblacionid: ctrl.poblacionid,
                      poblacion: ctrl.poblacion,
                      codigopostalid: ctrl.codigopostalid,
                    };

                    presupuestoService.nuevoProveedor(newProveedor).then(function (response){
                        toastr.success('Creado correctamente');
                        $uibModalInstance.close(response.data);
                    });
                }, function (error) {
                    
                     toastr.info('El fichero debe ser tipo. ' + type, 'info');
                },function (evt) {
                    let progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });
           
        };

      ctrl.nuevo_proveedor = function($event, file)
      {
        $event.stopImmediatePropagation();
        $event.preventDefault();

        if(file == undefined)
          {
               toastr.info('Primero capture una imagen','info')
          }
          
         if (file){
              ctrl.uploadFile(file, '/emp/logo/upload', 'jpg');
          }
        
        

      }
     

      ctrl.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
    }
]);