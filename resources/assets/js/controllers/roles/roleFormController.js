import {erp} from '../../app.js';

erp.controller(
    'roleFormController',
    [
        '$scope',
        'roleService',
        '$uibModalInstance',
        'permissions',
        'toastr',
        function (
            $scope,
            roleService,
            $uibModalInstance,
            permissions,
            toastr
        ) {
            let $modalDetails = this
            $modalDetails.permissions = permissions
            $modalDetails.localLang = {
                selectAll: 'Seleccionar todo',
                selectNone: 'Ninguno',
                reset: 'Deshacer selección',
                search: 'Buscar...',
                nothingSelected: 'Sin Selección'
            };
            $modalDetails.sendForm = sendForm

            function sendForm ($event, roleForm) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                if (!roleForm.$invalid) {
                    const formRoleData = {
                        name: $modalDetails.name,
                        description: $modalDetails.description,
                        permissionSelection: $modalDetails.selectedPermissions
                    }
                    roleService.new(formRoleData).then(function (response) {
                        $uibModalInstance.close(response)
                    }, function (error) {
                        toastr.error('No se ha podido crear el rol');
                        console.error(error);
                    });
                }
            };
        }
    ])
;
