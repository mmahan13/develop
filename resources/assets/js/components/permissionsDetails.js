import {erp} from '../app.js'

erp.component('permissionsDetails', {
    template: `
        <button
            class="btn btn-default"
            ng-click="$permissionsDetails.details($event)">
                <i class="fa fa-bars"></i>
        </button>`,
    bindings: {
        permissionId: '<',
        permission: '='
    },
    controllerAs: '$permissionsDetails',
    controller:
    [
        '$rootScope',
        '$scope',
        'permissionService',
        '$uibModal',
        'toastr',
        function adminUsers(
            $rootScope,
            $scope,
            permissionService,
            $uibModal,
            toastr
        ) {
            let $permissionsDetails = this
            $permissionsDetails.details = details

            function details($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-permission-details.html',
                    controllerAs: '$modalDetails',
                    controller: 'permissionDetailsController',
                    size: 'lg',
                    resolve: {
                        permissionID: function () {
                            return $permissionsDetails.permissionId
                        },
                        permission: function () {
                            let permission
                            return permissionService.details($permissionsDetails.permissionId).then((response) => {
                                const {permissionData} = response.data
                                permission = permissionData
                                return permission
                            })
                        }
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El permiso ha sido actualizado satisfactoriamente')
                            permissionService.details($permissionsDetails.permissionId).then(function (response) {
                                const {permissionData: permissionD} = response.data
                                $permissionsDetails.permission = permissionD
                            })
                        }
                        if (modalResponse.status === 500) {
                            toastr.error('No se ha podido actualizar el permiso')
                        }
                    }
                }, function () {
                    // console.log('Modal dismissed at: ' + new Date())
                })
            }
        }
    ]
});
