// <section-menu-item item-name="userList" inner-text="Listado" default-item="true"></section-menu-item>
import {erp} from '../app.js';

erp.directive('sectionMenuItem', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        replace: true,
        template: '<a href="#" class="nsc-lnk-left-menu"></a>',
        link: function (scope, element, attr) {
            element.text(attr['innerText']);
            angular.element(document).ready(function () {
                if (angular.isDefined(attr['defaultItem'])) {
                    activateSignal();
                }
            });
            element.bind('click', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                activateSignal();
            });

            function activateSignal() {
                const selectors = document.querySelectorAll('div.left-menu-item-selected');
                for (let i = 0; i < selectors.length; i++) {
                    selectors[i].classList.remove('left-menu-item-selected');
                }
                element.parent().addClass('left-menu-item-selected');
                $rootScope.$broadcast('left_menu_selection', attr['itemName']);
                $rootScope.currentView = attr['itemName'];
            }
        }
    }
}]);
