import {erp} from '../../app.js';

erp.controller(
    'userDetailsController',
    [
        '$scope',
        'userService',
        '$uibModalInstance',
        'userID',
        'user',
        'roles',
        function (
            $scope,
            userService,
            $uibModalInstance,
            userID,
            user,
            roles
        ) {
            let $modalDetails = this
            $modalDetails.userID = userID
            $modalDetails.user = user
            $modalDetails.user.changePass = false
            $modalDetails.password = 'null'
            $modalDetails.confirm = 'null'
            $modalDetails.editMode = true
            $modalDetails.localLang = {
                selectAll: 'Seleccionar todo',
                selectNone: 'Ninguno',
                reset: 'Deshacer selección',
                search: 'Buscar...',
                nothingSelected: 'Sin Selección'
            }
            $modalDetails.name = user.name
            $modalDetails.dni = user.dni
            $modalDetails.email = user.email
            $modalDetails.roles = []
            $modalDetails.roles = user.roles.map((rol) => {
                rol.selected = true
                return rol
            });
            $modalDetails.selectedRoles = _.cloneDeep($modalDetails.roles)

            $modalDetails.roles =
                _.differenceBy(
                    roles,
                    $modalDetails.roles,
                    'id'
                ).concat($modalDetails.roles);
            _.orderBy($modalDetails.roles, 'description', 'asc')

            // delete user modal
            $modalDetails.objectName = $modalDetails.name;
            $modalDetails.message = 'Se eliminará el usuario y toda su información. ¿Desea continuar con el borrado?';
            $modalDetails.sendForm = sendForm

            function sendForm ($event, userForm) {
                $event.stopImmediatePropagation()
                $event.preventDefault()

                const userServiceForm = {
                    name:  $modalDetails.name,
                    dni:  $modalDetails.dni,
                    email:  $modalDetails.email,
                    roles:  $modalDetails.selectedRoles,
                    password:  $modalDetails.password,
                    confirm:  $modalDetails.confirm,
                }
                if (!userForm.$invalid) {
                    userService
                        .update($modalDetails.userID, userServiceForm)
                        .then(function (response) {
                            $uibModalInstance.close(response)
                        })
                        .catch(function (error) {
                            $uibModalInstance.close(error);
                            console.error(error)
                        })
                }
            };
        }
    ]
);
