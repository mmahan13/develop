import {erp} from '../app.js'

erp.controller(
    'adminController',
    [
        '$rootScope',
        '$scope',
        'userService',
        'roleService',
        'permissionService',
        '$uibModal',
        'toastr',
        function (
            $rootScope,
            $scope,
            userService,
            roleService,
            permissionService,
            $uibModal,
            toastr
        ) {
            $scope.$on('left_menu_selection', function (event, data) {
                switch (String(data)) {
                    case 'users.user_list':
                        break
                    case 'users.role_list':
                        break
                    case 'users.permission_route':
                        break
                    case 'users.user_add':
                        break
                    case 'users.role_add':

                        break
                }
            })
            $scope.roleDetails = roleDetails
            $scope.deleteRole = deleteRole

            function roleDetails($event, roleID) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-role-details.html',
                    controller: 'roleDetailsController',
                    size: 'lg',
                    resolve: {
                        roleID: function () {
                            return roleID
                        },
                        role: function () {
                            let role
                            return roleService.details(roleID).then((response) => {
                                const {roleService} = response.data
                                role = roleService
                                return role
                            })
                        },
                        permissions: function () {
                            let permissions
                            return permissionService.list().then((response) => {
                                const {permissionsService} = response.data
                                permissions = permissionsService
                                return permissions
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El perfil ha sido actualizado satisfactoriamente')
                            userService.listRoles().then(function (response) {
                                $scope.roles = response.data
                            })
                        }
                        if (modalResponse.status === 500) {
                            toastr.error('No se ha podido actualizar el perfil')
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }

            function deleteRole($event, roleID) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-delete-role.html',
                    controller: 'roleDetailsController',
                    size: 'lg',
                    resolve: {
                        roleID: function () {
                            return roleID
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El role ha sido Borrado')
                            userService.listRoles().then(function (response) {
                                $scope.roles = response.data
                            })
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }
        }
    ]
)
