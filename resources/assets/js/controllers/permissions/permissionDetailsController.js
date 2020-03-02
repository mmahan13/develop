import {erp} from '../../app.js';

erp.controller(
    'permissionDetailsController',
    [
        '$scope',
        'permissionService',
        '$uibModalInstance',
        'permissionID',
        'permission',
        function (
            $scope,
            permissionService,
            $uibModalInstance,
            permissionID,
            permission,
        ) {
            let $modalDetails = this
            $modalDetails.permissionID = permissionID
            $modalDetails.permission = permission
            $modalDetails.module = permission.module
            $modalDetails.name = permission.name
            $modalDetails.description = permission.description
            $modalDetails.route = permission.route
            $modalDetails.sendForm = sendForm

            function sendForm ($event, permissionForm) {
                $event.stopImmediatePropagation()
                $event.preventDefault()

                const permissionFormData = {
                    module:  $modalDetails.module,
                    name:  $modalDetails.name,
                    description:  $modalDetails.description,
                    route:  $modalDetails.route,
                }
                if (!permissionForm.$invalid) {
                    permissionService
                        .update($modalDetails.permissionID, permissionFormData)
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
