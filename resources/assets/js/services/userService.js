import {erp} from '../app.js';

erp.service('userService', ['$http', function ($http) {
    this.formatedRolesUser = user => {
        user.roles.roles = user.roles.map(function (x) {
            return x.description
        }).join(', ');
    }
    this.formatUserList = (users) => {
        _.forEach(users, (user, ind) => formatedRoles(user));
        return users;
    };
    this.list = () => $http.get(`/users/list`);
    this.new = data => $http.post(`/users/new`, data)
    this.details = userID => $http.get(`/users/${userID}/details`)
    this.update = (userID, data) => $http.post(`/users/${userID}/update`, data);
    this.existsNif = nif => $http.get(`/users/${nif}/exists/nif`);
    this.existsEmail = email => $http.get(`/users/${email}/exists/email`);
    this.delete = userID => $http.post(`/users/${userID}/delete`);

    function formatedRoles(user) {
        user.roles.roles = user.roles.map(function (x) {
            return x.description
        }).join(', ');
    }
}]);
