import {erp} from '../app.js';

erp.service(`roleService`, ['$http', function ($http) {
    this.list = () => $http.get(`/roles/list`)
    this.permissions = (roleID) => $http.get(`/role/${roleID}/permissions`)
    this.update = (roleID, data) => $http.post(`roles/${roleID}/update`, data)
    this.delete = (roleID) => $http.post(`/roles/${roleID}/delete`)
    this.details = (roleID) => $http.get(`/roles/${roleID}/details`)
    this.new = (data) => $http.post(`/roles/new`, data)
}]);
