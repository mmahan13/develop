import {erp} from '../app.js';

erp.service('permissionService', ['$http', function ($http) {
    this.list = () => $http.get('/permissions/list');
    this.new = data => $http.post(`/permissions/new`, data)
    this.details = permissionID => $http.get(`/permissions/${permissionID}/details`)
    this.update =
        (permissionID, data) => $http.post(`/permissions/${permissionID}/update`, data);
    this.delete = permissionID => $http.post(`/permissions/${permissionID}/delete`);
}]);
