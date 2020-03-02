import {erp} from '../../app.js';

erp.controller(
    'permissionFormController',
    [
        '$scope',
        'permissionService',
        '$uibModalInstance',
        'toastr',
        function (
            $scope,
            permissionService,
            $uibModalInstance,
            toastr
        ) {
            let $modalDetails = this
            $modalDetails.localLang = {
                selectAll: 'Seleccionar todo',
                selectNone: 'Ninguno',
                reset: 'Deshacer selección',
                search: 'Buscar...',
                nothingSelected: 'Sin Selección'
            };
            $modalDetails.sendForm = sendForm

            function sendForm($event, permissionForm) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                const permissionFormData = {
                    module:  $modalDetails.module,
                    name:  $modalDetails.name,
                    description:  $modalDetails.description,
                    route:  $modalDetails.route,
                }
                if (!permissionForm.$invalid) {
                    permissionService.new(permissionFormData).then(function (response) {
                        if (response.status === 200) {
                            toastr.success('El permiso ha sido creado satisfactoriamente');
                        }
                    }, function (error) {
                        toastr.error('No se ha podido crear el permiso');
                        console.error(error);
                    });
                }
            };
        }
    ]
);
