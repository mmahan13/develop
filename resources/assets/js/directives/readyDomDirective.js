/**
 * Created by agf on 17/05/2017.
 */
// <div class="hidden" ready-dom-directive></div>
import {erp} from '../app.js';

erp.directive('readyDomDirective', [function () {
    return function (scope, element, attr, ctrl) {
        element.removeClass('hidden');
    }
}]);
