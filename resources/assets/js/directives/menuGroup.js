import {erp} from '../app.js';

erp.directive('menuGroup', function() {
    return {
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: {
            name: '@',
            default: '@',
        },
        controller: ['$scope', function MenuGroupController($scope) {
            $scope.nameid = $scope.name.toLowerCase()
                .replace(new RegExp(/\s/g),"")
                .replace(new RegExp(/[\_\-\.\,\:\;\\\/\=\<\>\+\*]/g),"")
                .replace(new RegExp(/[àáâãäå]/g),"a")
                .replace(new RegExp(/[èéêë]/g),"e")
                .replace(new RegExp(/[ìíîï]/g),"i")
                .replace(new RegExp(/ñ/g),"n")
                .replace(new RegExp(/[òóôõö]/g),"o")
                .replace(new RegExp(/[ùúûü]/g),"u");

            $scope.collapse = function ($event) {
                angular.element(document.getElementsByClassName('panel')).addClass('hide');
                angular.element(document.getElementsByClassName('left-menu-item-selected')).removeClass('left-menu-item-selected');
                angular.element($event.currentTarget).closest('.collapse-group').siblings('.card, .collapse-group').find('.collapse').collapse('hide');
            };

            this.nameGroupId = $scope.nameid;
            this.defaultPanelGroup = $scope.default;
        }],
        link: function(scope, element, attrs, ctrl) {
            if (scope.default != undefined) {
                setTimeout(() => {
                    element.find('.card-header#blockgroup'+scope.nameid+' .btn.collapsed').trigger('click');
                }, 300);
            }
        },
        template: `
            <div class="collapse-group">
                <div class="card nsc-card-left-menu">
                    <div class="card-header nsc-head-left-menu" id="blockgroup{%nameid%}">
                        <h5 class="mb-0">
                            <button class="btn nsc-btn-left-menu collapsed" type="button" data-toggle="collapse" data-target="#group{%nameid%}" aria-expanded="true" aria-controls="group{%nameid%}" ng-click="collapse($event)">
                            {%name%}
                            </button>
                        </h5>
                    </div>
                    <div id="group{%nameid%}" class="collapse" aria-labelledby="blockgroup{%nameid%}">
                        <div class="card-body-new">
                            <div ng-transclude></div>
                        </div>
                    </div>
                </div>
            </div>`
    };
})
