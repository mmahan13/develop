import {erp} from '../app.js';

erp.controller('leftMenuController', ['$rootScope', '$scope', '$uibModal', 'toastr',
    function ($rootScope, $scope, $uibModal, toastr) {
        $scope.deleteFolder = function ($event, folderId, folderName) {
            $event.preventDefault();
            $event.stopImmediatePropagation();
            var modal = $uibModal.open({
                animation: this.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'modal-delete-file.html',
                controller: 'folderDetailsController',
                size: 'lg',
                resolve: {
                    Id: function () {
                        return folderId;
                    },
                    folder: function () {
                        return folderName;
                    }
                }
            });
            modal.result.then(function (modalResponse) {
                console.log(modalResponse);
                if (modalResponse) {
                    if (modalResponse.status === 200) {
                        toastr.success('La carpeta ha sido borrada');
                        location.reload();
                    }
                }
            }, function () {
                // console.log('Modal dismissed at: ' + new Date());
            });
        };

    }
]);
