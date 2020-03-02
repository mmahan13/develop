import {erp} from '../app.js';

erp.directive('menuItem', ['$location', '$rootScope', function($location, $rootScope) {
    return {
        require: '^^menuElement',
        restrict: 'E',
        replace: true,
        scope: {
            name: '@',
            panel: '@'
        },
        link: function(scope, element, attrs, ctrl) {
            element.bind('click', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();

                angular.element(document.getElementsByClassName('panel')).addClass('hide');
                angular.element(document.getElementById(scope.panel)).removeClass('hide');
                angular.element(document.getElementsByClassName('left-menu-item-selected')).removeClass('left-menu-item-selected');
                element.addClass('left-menu-item-selected');
                $rootScope.$broadcast('left_menu_selection', scope.panel);
            });
        },
        template: `
            <div class="card-body-new">
                <a href="" class="nsc-lnk-left-menu" id="link-{%panel%}" data-panel="{%panel%}">{%name%}</a>
            </div>`
    };
}]);
