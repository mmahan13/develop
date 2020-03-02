import {erp} from '../app.js';

erp.service('adminService', ['$http', function ($http) {
    this.index = () => $http.get(`/admin`);
}]);
