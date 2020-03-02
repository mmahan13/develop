import {erp} from '../app.js'

erp.component('usersList', {
    templateUrl: 'user-list.html',
    controllerAs: '$users',
    controller:
    [
        '$rootScope',
        '$scope',
        'userService',
        'roleService',
        '$uibModal',
        'toastr',
        '$mdDialog',
        function adminUsers(
            $rootScope,
            $scope,
            userService,
            roleService,
            $uibModal,
            toastr,
            $mdDialog
        ) {
            let $users = this
            $users.delete = deleteUser
            $users.addUser = addUser
            this.$onInit = function() {
                userService.list().then(function (response) {
                    const {users} = response.data
                    $users.users = userService.formatUserList(users)
                })
            }

            function deleteUser33 ($event, userID) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-delete-user.html',
                    controllerAs: '$modalDetails',
                    controller: 'userDetailsController',
                    size: 'lg',
                    resolve: {
                        userID: function () {
                            return userID
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El usuario ha sido Borrado')
                            userService.listUsers().then(function (response) {
                                $scope.users = userService.formatUserList(response.data)
                            })
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }

            function deleteUser ($event, userID) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                let confirm = $mdDialog.confirm()
                    .title('¿Está seguro de eliminar el usuario?')
                    .textContent('Esta acción será definitiva y no habrá forma de recuperar los datos.')
                    .ariaLabel('Borrar usuario')
                    .targetEvent($event)
                    .ok('Borrar')
                    .cancel('Cancelar')
                $mdDialog.show(confirm).then(function () {
                    userService.delete(userID).then(function (res) {
                        toastr.success('El usuario ha sido eliminado satisfactoriamente')
                        userService.list().then(function (response) {
                            const {users} = response.data
                            $users.users = userService.formatUserList(users)
                        })
                    }, function (error) {
                        toastr.error('No se ha podido quitar el equipo')
                    });
                }, function () {
                    // console.log('cancela');
                })
            }
            function addUser ($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-user-add.html',
                    controllerAs: '$modalDetails',
                    controller: 'userFormController',
                    size: 'lg',
                    resolve: {
                        roles: function () {
                            let rolesSelect
                            return roleService.list().then((response) => {
                                const {roles} = response.data
                                rolesSelect = roles
                                return rolesSelect
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El usuario ha sido creado')
                            userService.list().then(function (response) {
                                $scope.users = userService.formatUserList(response.data)
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
