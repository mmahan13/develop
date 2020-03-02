import {erp} from '../app.js'

erp.component('rolesDetails', {
    template: `
        <button
            class="btn btn-default"
            ng-click="$rolesDetails.details($event)">
                <i class="fa fa-bars"></i>
        </button>`,
    bindings: {
        roleId: '<',
        role: '='
    },
    controllerAs: '$rolesDetails',
    controller:
    [
        '$rootScope',
        '$scope',
        'roleService',
        'permissionService',
        '$uibModal',
        'toastr',
        function adminUsers(
            $rootScope,
            $scope,
            roleService,
            permissionService,
            $uibModal,
            toastr
        ) {
            let $rolesDetails = this
            $rolesDetails.details = details

            function details($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-role-details.html',
                    controllerAs: '$modalDetails',
                    controller: 'roleDetailsController',
                    size: 'lg',
                    resolve: {
                        roleID: function () {
                            return $rolesDetails.roleId
                        },
                        role: function () {
                            let role
                            return roleService.details($rolesDetails.roleId).then((response) => {
                                const {roleData} = response.data
                                role = roleData
                                return role
                            })
                        },
                        permissions: function () {
                            let permissionsR
                            return permissionService.list().then((response) => {
                                const {permissions} = response.data
                                permissionsR = permissions
                                return permissionsR
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El usuario ha sido actualizado satisfactoriamente')
                            roleService.details($rolesDetails.roleId).then(function (response) {
                                const {roleData: roleD} = response.data
                                $rolesDetails.role = roleD
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
