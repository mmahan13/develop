import {erp} from '../app.js';

erp.directive(
    'listenerPanel',
    [
        '$rootScope',
        '$http',
        '$compile',
        function ($rootScope, $http, $compile) {
            return {
                restrict: 'A',
                scope: {
                    eventName: '@',
                    trigger: '@'
                },
                link: function (scope, element, attr) {
                    $rootScope.$on(scope.eventName, function (event, data) {
                        $http.get(`/panel/${data}`).then((resp) => {
                            element.html('<div></div>')
                            const panel = resp.data
                            const panelCompiled = $compile(panel)(scope)
                            element.append(panelCompiled)
                        })
                    });
                }
            }
        }
    ]
);
