import {erp} from '../app.js'

erp.component('usersDetails', {
    template: `
        <button
            class="btn btn-default"
            ng-click="$usersDetails.details($event)">
                <i class="fa fa-bars"></i>
        </button>`,
    bindings: {
        userId: '<',
        user: '='
    },
    controllerAs: '$usersDetails',
    controller:
    [
        '$rootScope',
        '$scope',
        'userService',
        'roleService',
        '$uibModal',
        'toastr',
        function adminUsers(
            $rootScope,
            $scope,
            userService,
            roleService,
            $uibModal,
            toastr
        ) {
            let $usersDetails = this
            $usersDetails.details = details

            function details($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-user-details.html',
                    controllerAs: '$modalDetails',
                    controller: 'userDetailsController',
                    size: 'lg',
                    resolve: {
                        userID: function () {
                            return $usersDetails.userId
                        },
                        user: function () {
                            let user
                            return userService.details($usersDetails.userId).then((response) => {
                                const {userData} = response.data
                                user = userData
                                return user
                            })
                        },
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
                            toastr.success('El usuario ha sido actualizado satisfactoriamente')
                            userService.details($usersDetails.userId).then(function (response) {
                                const {userService: userD} = response.data
                                userService.formatedRolesUser(userD)
                                $usersDetails.user = userD
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
        }
    ]
});
