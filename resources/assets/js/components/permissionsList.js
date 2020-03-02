import {erp} from '../app.js'

erp.component('permissionsList', {
    templateUrl: 'permission-list.html',
    controllerAs: '$permissions',
    controller:
    [
        '$rootScope',
        '$scope',
        'permissionService',
        '$uibModal',
        'toastr',
        '$mdDialog',
        function adminPermission(
            $rootScope,
            $scope,
            permissionService,
            $uibModal,
            toastr,
            $mdDialog
        ) {
            let $permissions = this
            $permissions.delete = deletePermission
            $permissions.addPermission = addPermission
            this.$onInit = function() {
                permissionService.list().then(function (response) {
                    const {permissions} = response.data
                    $permissions.permissions = permissions
                })
            }

            function deletePermission ($event, permissionID) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                let confirm = $mdDialog.confirm()
                    .title('¿Está seguro de eliminar el permiso?')
                    .textContent('Esta acción será definitiva y no habrá forma de recuperar los datos.')
                    .ariaLabel('Borrar permiso')
                    .targetEvent($event)
                    .ok('Borrar')
                    .cancel('Cancelar')
                $mdDialog.show(confirm).then(function () {
                    permissionService.delete(permissionID).then(function (res) {
                        toastr.success('El usuario ha sido eliminado satisfactoriamente')
                        permissionService.list().then(function (response) {
                            const {permissions} = response.data
                            $permissions.permissions = permissions
                        })
                    }, function (error) {
                        toastr.error('No se ha podido quitar el equipo')
                    });
                }, function () {
                    // console.log('cancela');
                })
            }
            function addPermission ($event) {
                $event.preventDefault()
                var modal = $uibModal.open({
                    animation: this.animationsEnabled,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'modal-permission-add.html',
                    controllerAs: '$modalDetails',
                    controller: 'permissionFormController',
                    size: 'lg',
                    resolve: {
                    }
                })
                modal.result.then(function (modalResponse) {
                    if (modalResponse) {
                        if (modalResponse.status === 200) {
                            toastr.success('El permiso ha sido creado')
                            permissionService.list().then(function (response) {
                                const {permissions} = response.data
                                $scope.permissions = permissions
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
