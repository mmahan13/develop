import {erp} from '../../app.js'

erp.controller(
    'usersController',
    [
        '$rootScope',
        '$scope',
        'userService',
        'roleService',
        '$uibModal',
        'toastr',
        function (
            $rootScope,
            $scope,
            userService,
            roleService,
            $uibModal,
            toastr
        ) {
            $users = this
            $users.userDetails = userDetails
            $scope.deleteUser = deleteUser
            this.$onInit = function() {
                userService.list().then(function (response) {
                    $users.users = userService.formatUserList(response.data)
                })
            }

            function userDetails($event, userID) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-user-details.html',
                    controller: 'userDetailsController',
                    size: 'lg',
                    resolve: {
                        userID: function () {
                            return userID
                        },
                        user: function () {
                            let user
                            return userService.details(userID).then((response) => {
                                const {userData} = response.data
                                user = userData
                                return user
                            })
                        },
                        roles: function () {
                            let roles
                            return roleService.list().then((response) => {
                                const {rolesData} = response.data
                                roles = rolesData
                                return roles
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El usuario ha sido actualizado satisfactoriamente')
                            userService.listUsers().then(function (response) {
                                $users.users = userService.formatUserList(response.data)
                            })
                        }
                        if (modalResponse.status === 500) {
                            toastr.error('No se ha podido actualizar el usuario')
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }

            function deleteUser ($event, userID) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-delete-user.html',
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
        }
    ]
)
