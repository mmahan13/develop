import {erp} from '../../app.js';

erp.controller(
    'userFormController',
    [
        '$scope',
        'userService',
        '$uibModalInstance',
        'roles',
        'toastr',
        function (
            $scope,
            userService,
            $uibModalInstance,
            roles,
            toastr
        ) {
            let $modalDetails = this
            $modalDetails.localLang = {
                selectAll: 'Seleccionar todo',
                selectNone: 'Ninguno',
                reset: 'Deshacer selección',
                search: 'Buscar...',
                nothingSelected: 'Sin Selección'
            };
            $modalDetails.roles = roles
            $modalDetails.sendForm = sendForm

            $scope.$watch('$modalDetails.dni', function (newVal, oldVal) {
                if (!angular.isUndefined(newVal)) {
                    if (newVal.length === 9) {
                        userService.existsNif(newVal).then(function (response) {
                            if (response.data.exists === false) {
                                $scope.userForm.dni.$setValidity('dni', true)
                            } else {
                                $scope.userForm.dni.$setValidity('dni', false)
                            }
                        });
                    }
                }
            });
            $scope.$watch('$modalDetails.email', function (newVal, oldVal) {
                if (!angular.isUndefined(newVal)) {
                    userService.existsEmail(newVal).then(function (response) {
                        if (response.data.exists === false) {
                            $scope.userForm.email.$setValidity('email', true)
                        } else {
                            $scope.userForm.email.$setValidity('email', false)
                        }
                    });
                }
            });
            $scope.$watch('$modalDetails.selectedRoles', function (newVal, oldVal) {
                if (!angular.isUndefined(newVal)) {
                    if (newVal.length > 0) {
                        $scope.userForm.selectedRoles.$setValidity('selectedRoles', true);
                    } else {
                        $scope.userForm.selectedRoles.$setValidity('selectedRoles', false);
                    }
                }
            });
            $scope.$watch('$modalDetails.confirm', function (newVal, oldVal) {
                if (!angular.isUndefined(newVal)) {
                    if (newVal === $scope.password) {
                        $scope.userForm.confirm.$setValidity('passMatch', true);
                    } else {
                        $scope.userForm.confirm.$setValidity('passMatch', false);
                    }
                }
            });

            function sendForm($event, userForm) {
                $event.stopImmediatePropagation();
                $event.preventDefault();
                const userServiceForm = {
                    name:  $modalDetails.name,
                    dni:  $modalDetails.dni,
                    email:  $modalDetails.email,
                    roles:  $modalDetails.selectedRoles,
                    password:  $modalDetails.password,
                    confirm:  $modalDetails.confirm,
                }
                if (!userForm.$invalid) {
                    userService.new(userServiceForm).then(function (response) {
                        if (response.status === 200) {
                            toastr.success('El usuario ha sido creado satisfactoriamente');
                        }
                    }, function (error) {
                        toastr.error('No se ha podido crear el usuario');
                        console.error(error);
                    });
                }
            };
        }
    ]
);
