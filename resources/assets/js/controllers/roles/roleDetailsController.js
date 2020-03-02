import {erp} from '../../app.js';

erp.controller(
    'roleDetailsController',
    [
        '$scope',
        'userService',
        'roleService',
        '$uibModalInstance',
        'roleID',
        'role',
        'permissions',
        function (
            $scope,
            userService,
            roleService,
            $uibModalInstance,
            roleID,
            role,
            permissions
        ) {
            let $modalDetails = this
            $modalDetails.localLang = {
                selectAll: 'Seleccionar todo',
                selectNone: 'Ninguno',
                reset: 'Deshacer selección',
                search: 'Buscar...',
                nothingSelected: 'Sin Selección'
            }
            $modalDetails.sendForm = sendForm

            $modalDetails.name = role.name;
            $modalDetails.description = role.description;
            $modalDetails.permissions = role.permissions;

            $modalDetails.permissions.map(function (obj) {
                obj.selected = true;
            });

            $modalDetails.selectedPermissions = _.cloneDeep($modalDetails.permissions);

            $modalDetails.permissions =
                _.differenceBy(
                    permissions,
                    $modalDetails.permissions,
                    'id'
                ).concat($modalDetails.permissions);
            _.orderBy($modalDetails.permissions, 'Description', 'asc');

            // delete user modal
            $modalDetails.objectName = $modalDetails.description;
            $modalDetails.message = 'Se eliminará el perfil y toda su información. ¿Desea continuar con el borrado?';

            function sendForm ($event, roleForm) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                const formRoleData = {
                    name: $modalDetails.name,
                    description: $modalDetails.description,
                    permissionSelection: $modalDetails.selectedPermissions
                }
                if (!roleForm.$invalid) {
                    roleService.update(roleID, formRoleData).then(function (response) {
                        $uibModalInstance.close(response);
                    }, function (error) {
                        $uibModalInstance.close(error);
                        console.error(error);
                    });
                }
            };
        }
    ]
);
