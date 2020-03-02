import {erp} from '../app.js'

erp.component('rolesList', {
    templateUrl: 'role-list.html',
    controllerAs: '$roles',
    controller:
    [
        '$rootScope',
        '$scope',
        'roleService',
        'permissionService',
        '$uibModal',
        'toastr',
        '$mdDialog',
        function adminRoles(
            $rootScope,
            $scope,
            roleService,
            permissionService,
            $uibModal,
            toastr,
            $mdDialog
        ) {
            let $roles = this
            $roles.delete = deleteRole
            $roles.addRole = addRole
            this.$onInit = function() {
                roleService.list().then(function (response) {
                    const {roles} = response.data
                    $roles.roles = roles
                })
            }

            function deleteRole ($event, roleID) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                let confirm = $mdDialog.confirm()
                    .title('¿Está seguro de eliminar el rol?')
                    .textContent('Esta acción será definitiva y no habrá forma de recuperar los datos.')
                    .ariaLabel('Borrar rol')
                    .targetEvent($event)
                    .ok('Borrar')
                    .cancel('Cancelar')
                $mdDialog.show(confirm).then(function () {
                    roleService.delete(roleID).then(function (res) {
                        toastr.success('El usuario ha sido eliminado satisfactoriamente')
                        roleService.list().then(function (response) {
                            const {roles} = response.data
                            $roles.roles = roles
                        })
                    }, function (error) {
                        toastr.error('No se ha podido quitar el equipo')
                    });
                }, function () {
                    // console.log('cancela');
                })
            }
            function addRole ($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-role-add.html',
                    controllerAs: '$modalDetails',
                    controller: 'roleFormController',
                    size: 'lg',
                    resolve: {
                        permissions: function () {
                            let permissionsSelect
                            return permissionService.list().then((response) => {
                                const {permissions} = response.data
                                permissionsSelect = permissions
                                return permissionsSelect
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El perfil ha sido creado')
                            roleService.list().then(function (response) {
                                const {roles} = response.data
                                $scope.roles = roles
                            })
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }
        }
    ]
});
