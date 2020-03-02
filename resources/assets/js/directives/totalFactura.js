import {erp} from '../app.js';
erp.directive('stTotalImporte', function () {
    return {
        restrict: 'E',
        require: '^stTable',
        template: '<div>{%title%} {%size |number:2%}</div>',
        scope: {title: '@', predicate: '@'},
        link: function (scope, element, attr, table) {
            scope.$watch(table.getFilteredCollection, function (val) {
                if(angular.isDefined(val)){
                     scope.size = 0;
                     for (var j = 0; j < (val || []).length; j++) scope.size += val[j][scope.predicate];
                        
                }
                 
            },true);
        }
    }
});