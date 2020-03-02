import {erp} from '../../app.js';

erp.controller('datosContratoModalController', ['$rootScope', '$scope', '$uibModal','$uibModalInstance','toastr','detalle','Upload',
    'MaterialCalendarData', 'moment','contratosService',
    function ($rootScope, $scope, $uibModal,$uibModalInstance, toastr, detalle, Upload, MaterialCalendarData, moment, contratosService){
    
    var ctrl = this;
    //console.log(detalle);
    ctrl.cabecera_contrato = [];
    ctrl.idcontrato = detalle.idcontrato;
    ctrl.numerocontrato = detalle.numerocontrato;
    ctrl.ejercicio = detalle.ejercicio;
    ctrl.razonsocial = detalle.razonsocial;
    ctrl.fechaactivacion = detalle.fechaactivacion == 'Invalid date' ? '--/--/----':detalle.fechaactivacion;
    ctrl.fechacontrato = detalle.fechacontrato;
    ctrl.fechafinal = detalle.fechafinal;
    ctrl.cifdni = detalle.cifdni;
    ctrl.telefono = detalle.telefono;
    ctrl.estado = detalle.estado;
    ctrl.renueva = detalle.renueva;
    ctrl.cabecera_contrato.push(detalle);

    contratosService.tienePlanFacturado({idcontrato:ctrl.idcontrato}).then(function success(response)
    {
        ctrl.facturado = response.data;

    },function error(response){
              toastr.info('No se ha podido comprobar si tiene algún plan facturado');
              return '';
    });  


    $rootScope.$on('fechaActivacionCabeceraContrato', function(event, data)
    {
        if(ctrl.lineas_contrato.length == 0){
             toastr.info('Primero añada una línea al contrato');
             return false;
        }

        if(ctrl.facturado == 0)
        {
            if(angular.isObject(data))
            {
                ctrl.fechaactivacion = data.fechaactivacion;
                contratosService.cambiarFechaActivacionCabeceraContrato({fechaactivacion:ctrl.fechaactivacion, idcontrato:data.idcontrato}).then(function success(response)
                {
                    let respuesta = response.data; 
                    if(angular.isObject(respuesta))
                    {
                        toastr.success('Fecha cambiada');
                        ctrl.fechaactivacion = moment(ctrl.fechaactivacion).format("DD/MM/YYYY");
                        $rootScope.$emit('fechaactivacion_tabla', {fechaactivacion:ctrl.fechaactivacion, idcontrato: ctrl.idcontrato});
                    }    
                },function error(response){
                          toastr.info('Error al cambiar la fecha activación');
                          return '';
                });
            }
               
        }else{
            toastr.info('Error al cambiar la fecha de activación de la cabecera del contrato');
        }

        
    });

    $rootScope.$on('fechaActivacionLineaContrato', function(event, data){
        let fecha =  moment(data.nuevafechaactivacion).format("DD/MM/YYYY");
        if(fecha < data.fechainicio){
            toastr.info('F.Activación debe ser igual o posterior a la F.inició');
            return false;
        }
        contratosService.cambiarFechaActivacionLineaContrato({factivacion:data.nuevafechaactivacion, idlineacontrato:data.idlineacontrato}).then(function success(response)
        {
            let respuesta = response.data;
            if(angular.isObject(respuesta))
            {
                 toastr.success('Fecha cambiada correctamente');
                _.each(ctrl.lineas_contrato, function (obj, i)
                {
                  if(obj.idlineacontrato == data.idlineacontrato){
                    obj.factivacion = moment(data.nuevafechaactivacion).format("DD/MM/YYYY");
                  } 
                });
            }
           
        },function error(response){
           toastr.info('Error al cambiar la fecha activación de la línea del contrato');
           return '';
        });   
    });

    $rootScope.$on('inicioContrato', function(event, data){
        ctrl.fechacontrato = moment(data.fecha).format("DD/MM/YYYY");

        
       
    })
    $rootScope.$on('finalContrato', function(event, data){
        ctrl.fechafinal = moment(data.fecha).format("DD/MM/YYYY");
        //TODO lanzar la actualizacion de la fecha
    })

    let data = {idcontrato:detalle.idcontrato};
    contratosService.lineas(data).then(function success(response)
    {
        ctrl.lineas_contrato = response.data;
        _.each(ctrl.lineas_contrato, function (obj, i)
        {
          obj.unidades = parseInt(obj.unidades);
          obj.pordescuento = parseInt(obj.pordescuento) | 0; 
          obj.factivacion = moment(obj.factivacion).format("DD/MM/YYYY");
          obj.fechainicio = moment(obj.fechainicio).format("DD/MM/YYYY");
          obj.fechafinal = moment(obj.fechafinal).format("DD/MM/YYYY");
        });
        
    },function error(response){
              toastr.info('No se han cargado los contratos');
              return '';
    });

     $rootScope.$on('actualizarFechaLineaContrato', function(event, data){
        _.each(ctrl.lineas_contrato, function (obj, i)
        {
            
            if(obj.idlineacontrato == data.idlineacontrato){
                if(data.inicio == 0 && angular.isDefined(data.fechainicio)){
                     obj.fechainicio = data.fechainicio; 
                }
                if(data.inicio == 1 && angular.isDefined(data.fechafin)){
                     obj.fechafinal = data.fechafin; 
                }

                contratosService.actualizarFechalineaContrato(data).then(function success(response)
                {
                    let texto_fecha = data.inicio == 0 ? 'Fecha inicial actualizada': 'Fecha final actualizada';
                    if (response.status === 200) toastr.success(texto_fecha);

                },function error(response){
                          toastr.info('No se han cargado los contratos');
                          return '';
                });
              
            }
           //obj.fechafinal = moment(obj.fechafinal).format("DD/MM/YYYY");
        });
    })

    ctrl.planContrato = function($event, idcontrato, numerocontrato)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'plan-contrato-modal.html',
                controller: 'planContratoModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                        return {idcontrato:idcontrato, numerocontrato:numerocontrato};
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

    ctrl.addLinea = function($event, idcontrato, numerocontrato)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'add-lineas-contrato-modal.html',
                controller: 'addLineasContratoModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                        return {idcontrato:idcontrato, numerocontrato:numerocontrato};
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        let data = response;
                        console.log(data);
                        ctrl.datos = [];
                            _.each(data, function (o, i)
                            {
                                if(o.descripcionarticulo != '' && o.liquido > 0 && o.precioventa > 0)
                                {
                                    let nuevaLinea = {
                                        descripcionarticulo: o.descripcionarticulo,
                                        codigoarticulo: o.codigoarticulo,
                                        unidades: o.unidades,
                                        bajalinea: o.bajalinea,
                                        precio: o.precioventa,
                                        pordescuento: o.descuento,
                                        descuento: o.desc,
                                        neto: o.liquido, 
                                        idcontrato: idcontrato,
                                        grupoiva: parseInt(o.grupoiva),
                                        poriva:o.porcentaje,
                                        fechainicio: moment(new Date()).format("DD/MM/YYYY"),
                                        fechafinal: ctrl.fechafinal
                                    }
                                   ctrl.lineas_contrato.unshift(nuevaLinea);
                                   ctrl.datos.push(nuevaLinea);
                                    
                                }
                            });
                            contratosService.aniadirLinea(ctrl.datos).then(function success(response)
                            {
                                //console.log(response.data);
                                ctrl.cabecera_contrato = response.data['cabecera_contrato'];
                                _.each(ctrl.cabecera_contrato, function (obj, i)
                                {
                                    obj.importeneto = obj.importenetolineas;
                                    obj.importedescuento = obj.importedescuento | 0;
                                    obj.pordescuento = parseInt(obj.pordescuento) | 0; 
                                    obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
                                    obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
                                    obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
                                });

                                ctrl.lineas_contrato = response.data['lineas_contrato'];
                                _.each(ctrl.lineas_contrato, function (obj, i)
                                {
                                  obj.unidades = parseInt(obj.unidades);
                                  obj.pordescuento = parseInt(obj.pordescuento) | 0; 
                                  obj.fechainicio = moment(obj.fechaacticacion).format("DD/MM/YYYY");
                                  obj.fechaacticacion = moment(obj.fechainicio).format("DD/MM/YYYY");
                                  obj.fechafinal = moment(obj.fechafinal).format("DD/MM/YYYY");
                                });

                            $rootScope.$emit('actualizar_listado_cabecera',ctrl.cabecera_contrato); 

                            },function error(response){
                                      toastr.info('No se han cargado los contratos');
                                      return '';
                            });
                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    ctrl.editarCabeceraContrato = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'editar-cabecera-contrato-modal.html',
                controller: 'editarCabeceraContratoModalController',
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
                       ctrl.cabecera_contrato = data.cabecera_contrato;
                        _.each(ctrl.cabecera_contrato, function (obj, i)
                        {
                            obj.importenetolineas = obj.importenetolineas;
                            obj.importedescuento = obj.importedescuento | 0;
                            obj.pordescuento = parseInt(obj.pordescuento) | 0; 
                            obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
                            obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
                            obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
                        });

                        $rootScope.$emit('actualizar_listado_cabecera',ctrl.cabecera_contrato); 
                    }
                },
                function ()
                {
                    // dismiss
                });
    }


    ctrl.editarLineaContrato = function($event, row)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'editar-lineas-contrato-modal.html',
                controller: 'editarLineasContratoModalController',
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
                        //console.log(data);

                        ctrl.cabecera_contrato = data.cabecera_contrato;
                        _.each(ctrl.cabecera_contrato, function (obj, i)
                        {
                            obj.importeneto = obj.importenetolineas;
                            obj.importedescuento = obj.importedescuento | 0;
                            obj.pordescuento = parseInt(obj.pordescuento) | 0; 
                            obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
                            obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
                            obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
                        });

                        ctrl.lineas_contrato = data.lineas_contrato;
                        _.each(ctrl.lineas_contrato, function (obj, i)
                        {
                          obj.unidades = parseInt(obj.unidades);
                          obj.pordescuento = parseInt(obj.pordescuento) | 0;
                          obj.descuento = parseFloat(obj.descuento) | 0; 
                          obj.fechainicio = moment(obj.fechainicio).format("DD/MM/YYYY");
                          obj.fechafinal = moment(obj.fechafinal).format("DD/MM/YYYY");
                          obj.factivacion = moment(obj.factivacion).format("DD/MM/YYYY");
                        });

                        $rootScope.$emit('actualizar_listado_cabecera',ctrl.cabecera_contrato); 

                    }
                },
                function ()
                {
                    // dismiss
                });
    }

    
    ctrl.activarDesactivarArticulo = function($event, row)
    {   
        $event.stopImmediatePropagation();
        $event.preventDefault();
       _.each(ctrl.lineas_contrato, function (obj, i)
        {
            if(obj.idlineacontrato == row.idlineacontrato)
            {
                obj.bajalinea = obj.bajalinea == 0 ? 1 : 0;
                contratosService.actiDesactiArticulo({idcontrato:row.idcontrato, idlineacontrato:row.idlineacontrato, bajalinea:obj.bajalinea}).then(function success(response)
                {
                    ctrl.cabecera_contrato = response.data;;
                    _.each(ctrl.cabecera_contrato, function (obj, i)
                    {
                        obj.importeneto = obj.importenetolineas;
                        obj.importedescuento = obj.importedescuento | 0;
                        obj.pordescuento = parseInt(obj.pordescuento) | 0; 
                        obj.fechacontrato = moment(obj.fechacontrato).format('DD/MM/YYYY');
                        obj.fechaactivacion = moment(obj.fechaactivacion).format('DD/MM/YYYY');
                        obj.fechafinal = moment(obj.fechafinal).format('DD/MM/YYYY');
                    });

                    $rootScope.$emit('actualizar_listado_cabecera',ctrl.cabecera_contrato); 
                },function error(response){
                          toastr.info('Error al actualizar datos');
                          return '';
                });
            }
        });
    };

    ctrl.activarContrato = function($event, idcontrato)
    {   
        $event.stopImmediatePropagation();
        $event.preventDefault();
        if(ctrl.lineas_contrato.length == 0){
              toastr.info('Para activar debe añadir un artículo al contrato'); 
              return false;
        }

        if(angular.isDefined(idcontrato))
        {
            ctrl.estado = ctrl.estado == 0 ? 1 : 0;
            if(angular.isDefined(ctrl.estado))
            {
                contratosService.activar({idcontrato:idcontrato, fechainicio: ctrl.fechacontrato, estado:ctrl.estado}).then(function success(response)
                {
                    ctrl.cabecera_contrato = response.data;
                    //ctrl.estado == 0 ? toastr.success('Activado No') : toastr.success('Activado Si'); 
                    $rootScope.$emit('en_cabecera_activo',{idcontrato:ctrl.cabecera_contrato.idcontrato,fechacontrato:ctrl.cabecera_contrato.fechacontrato,estado:ctrl.cabecera_contrato.estado}); 
                
                },function error(response){
                          toastr.info('No se han cargado los contratos');
                          return '';
                });
            }
        }
    };

    ctrl.renuevaContrato = function($event, idcontrato)
    {   
        $event.stopImmediatePropagation();
        $event.preventDefault();

        if(angular.isDefined(idcontrato))
        {
            ctrl.renueva = ctrl.renueva == 0 ? 1 : 0;
            if(angular.isDefined(ctrl.renueva))
            {
                contratosService.renueva({idcontrato:idcontrato, renueva:ctrl.renueva}).then(function success(response)
                {
                    ctrl.cabecera_contrato = response.data;
                    //ctrl.renueva == 0 ? toastr.success('Renueva no') : toastr.success('Renueva si');
                    $rootScope.$emit('en_cabecera_renueva',{idcontrato:ctrl.cabecera_contrato.idcontrato,renueva:ctrl.cabecera_contrato.renueva}); 
                
                },function error(response){
                          toastr.info('Error al activar');
                          return '';
                });
            }
        }
    };

    ctrl.newFactura = function ($event)
    {
        $event.stopImmediatePropagation();
        $event.preventDefault();
         $uibModal.open({
                animation: ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'generar-factura-desde-contrato.html',
                controller: 'generarFacturaDesdeContratoModalController',
                controllerAs: '$ctrl',
                size: 'lg',
                scope: $scope, 
                 resolve: {
                    detalle: function()
                    {  
                        return {cabecera_factura:ctrl.cabecera_contrato, lineas_factura:ctrl.lineas_contrato};
                    }
                }
              
            }).result.then((response) => { 
                    if (response != null)
                    {
                        //let data = response;
                        //console.log(data);
                    }
                },
                function ()
                {
                    // dismiss
                });
       
    };

    ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
  }
]);

                                                                                          