export const erp = angular.module('erp',
    [
        'ngSanitize',
        'angucomplete-alt',
        'smart-table',
        'angular-loading-bar',
        'ngAnimate',
        'ui.bootstrap',
        'isteven-multi-select',
        'toastr',
        'ngFileSaver',
        'ngFileUpload',
        'ngMaterial',
        'materialCalendar',
        'angularMoment',
        'ui.grid', 'ui.grid.moveColumns', 'ui.grid.resizeColumns', 'ui.grid.edit', 'ui.grid.treeView', 'ui.grid.cellNav',
    ]
);
window.erp = erp
erp.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
}]);
erp.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 100;
    cfpLoadingBarProvider.includeSpinner = false;
}]);
erp.config(['toastrConfig', function (toastrConfig) {
    angular.extend(toastrConfig, {
        allowHtml: false,
        closeButton: true,
        progressBar: true,
        maxOpened: 1,
        preventOpenDuplicates: true,
    });
}]);

erp.config(['$compileProvider', function ($compileProvider) {
    const production = process.env.NODE_ENV === 'production' ? false : true
    $compileProvider.debugInfoEnabled(production);
}]);

erp.config(['$httpProvider', function ($httpProvider) {
    // $httpProvider.defaults.xsrfCookieName = 'XSRF-TOKEN_NSC_DOCS';
    $httpProvider.defaults.xsrfCookieName = $('meta[name="app-cookie-name"]').attr('content');
    $httpProvider.defaults.xsrfHeaderName = 'X-XSRF-TOKEN';
    $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    $httpProvider.interceptors.push(['$q', function ($q) {
        return {
            'responseError': function (response) {
                if (response.status === 401) {
                    window.location.href = '/';
                }
                return $q.reject(response);
            }
        }
    }]);
}]);


//Inicializar  RootScope
erp.run(['$http', '$rootScope', 'toastr',  function($http, $rootScope, toastr) {

    //Textos globales para validación
    $rootScope.defaultMsgRequired = "Campo obligatorio";
    //VARIABLE GLOBAL CON DEPENDENCIAS TOASTR
    $rootScope.showNotification = function (text, type) {

        //damos formato en función del tipo de alerta
        switch (type) {
        case 'success':
            toastr.success(text);
            break;
        case 'warning':

            toastr.warning(text);
            break;
        case 'warning-fix':

            toastr.warning('', text, {
                timeOut: 0,
                extendedTimeOut: 0
            });
            break;
        case 'success-top':
            toastr.success(text);
            window.scrollTo(0, 0);
            break;
        case 'info':
            toastr.info(text);
            break;
        case 'error':
            toastr.error(text, 
            {
                closeButton: true
            });
            break;
        }
    }; 

   

}]);
