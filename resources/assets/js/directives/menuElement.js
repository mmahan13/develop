import {erp} from '../app.js';

erp.directive('menuElement', function() {
    return {
        require: '?^^menuGroup',
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: {
            name: '@',
            default: '@',
        },
        controller: ['$scope', function MenuElementController($scope) {
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

                angular.element($event.currentTarget).closest('.card').siblings('.card, .collapse-group').find('.collapse').collapse('hide');
            };
        }],
        link: function(scope, element, attrs, ctrl) {
            if (ctrl != null) {
                scope.nameGroupId = ctrl.nameGroupId;
                scope.default = ctrl.defaultPanelGroup;
            } else {
                scope.nameGroupId = '';
            }
            if (scope.default != undefined) {
                setTimeout(() => {
                    if (element.find('#link-'+scope.default).length > 0) {
                        element.find('.card-header#block'+scope.nameid+' .btn.collapsed').trigger('click');
                        element.find('#link-'+scope.default).trigger('click');
                    }
                }, 300);
            }

        },
        template: `
            <div class="card nsc-card-left-menu">
                <div class="card-header nsc-head-left-menu" id="block{%nameid%}">
                    <h5 class="mb-0">
                        <button class="btn nsc-btn-left-menu collapsed" type="button" data-toggle="collapse" data-target="#element{%nameid%}{%nameGroupId%}" aria-expanded="true" aria-controls="element{%nameid%}{%nameGroupId%}" ng-click="collapse($event)">
                        {%name%}
                        </button>
                    </h5>
                </div>
                <div id="element{%nameid%}{%nameGroupId%}" class="collapse" aria-labelledby="block{%nameid%}">
                    <div ng-transclude></div>
                </div>
            </div>`
    };
})
