import {erp} from '../../app.js';

erp.controller('nuevoClienteModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','clientes', 'detalle','Upload',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, clientes, detalle, Upload){
    
      var ctrl = this;


      clientes.codigosPostales().then(function success(response)
      {
          ctrl.codigos_postales = response.data;
          //console.log(ctrl.codigos_postales);
        
      },
        function error(response){
            toastr.info('No hay codigos postales');
            return '';
      });

      

     $scope.$broadcast('angucomplete-alt:changeInput', 'cp_autocomplete', 
            _.find(ctrl.codigos_postales , function(o) { return o.codigopostalid == row.codigopostalid}));
     
      ctrl.currentProvincia = function(cp_autocomplete)
      {   
          ctrl.codigopostalid = cp_autocomplete.originalObject.codigopostalid;
          ctrl.provinciaid = cp_autocomplete.originalObject.provinciaid;
          ctrl.provincia = cp_autocomplete.originalObject.provincia;
          ctrl.poblacionid = cp_autocomplete.originalObject.poblacionid;
          ctrl.poblacion = cp_autocomplete.originalObject.poblacion;
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
                   let newCliente = {
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

                    clientes.nuevoCliente(newCliente).then(function (response){
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

      ctrl.cliente = [];
      ctrl.btn = 'Siguiente';
      ctrl.nuevo_cliente = function($event)
      {
        $event.stopImmediatePropagation();
        $event.preventDefault();

      
        if(ctrl.cliente.length == 0)
        {
          ctrl.newCliente = {
                      codigoempresa:3,
                      razonsocial: ctrl.razonsocial.toUpperCase(),
                      cifdni: ctrl.cifdni.toUpperCase(),
                      nombre1: ctrl.nombre1.toUpperCase(),
                      cargo1: ctrl.cargo1.toUpperCase(),
                      codigobanco: (angular.isDefined(ctrl.codigobanco)) ? ctrl.codigobanco:'',
                      iban: (angular.isDefined(ctrl.iban.toUpperCase())) ? ctrl.iban.toUpperCase():'',
                      email1: ctrl.email1,
                      email2: (angular.isDefined(ctrl.email2)) ? ctrl.email2:'',
                      porretencion:parseFloat(0),
                      siglanacion: 'ES'
          };
        }
        if(ctrl.cliente.length == 1)
        {
           ctrl.newDomicilio = {
                      codigoempresa:3,
                      tipodomicilio: 'F',
                      tipoportes: 'D',
                      codigosigla: ctrl.tipovia.sigla.sigla,
                      viapublica: ctrl.viapublica,
                      numero1: ctrl.numero1,
                      numero2: '',
                      escalera: ctrl.escalera,
                      piso: ctrl.piso,
                      puerta: ctrl.puerta,
                      codigopostal: ctrl.codigopostalid,
                      provinciaid: ctrl.provinciaid,
                      provincia: ctrl.provincia,
                      poblacionid: ctrl.poblacionid,
                      poblacion: ctrl.poblacion,
                      telefono: ctrl.telefono,
                      codigonacion: 108,
                      nacion:'ESPAÑA'

          }; 
          ctrl.cliente.push(ctrl.newDomicilio); 
        }else{
          ctrl.cliente.push(ctrl.newCliente);
          ctrl.btn = 'Guardar';
        }
        if(ctrl.cliente.length == 2)
        {
         
          clientes.nuevoCliente(ctrl.cliente).then(function (response)
          {
              toastr.success('Creado correctamente');
              $uibModalInstance.close(response.data);
              ctrl.btn = 'Siguiente';
          });
        }
                    
         /*if(file == undefined)
          {
               toastr.info('Primero capture una imagen','info')
          }
          
         if (file){
              ctrl.uploadFile(file, '/emp/logo/upload', 'jpg');
          }*/


      }
      
      ctrl.tipovia = {};
        ctrl.via = [
            {id:0, tipo:'Calle', sigla: 'CL'},
            {id:1, tipo:'Plaza', sigla: 'PZ'}
        ];
        //inicializo el option select
        ctrl.tipovia.sigla = ctrl.via[0];
        console.log(ctrl.tipovia.sigla.sigla)
      ctrl.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
    }
]);