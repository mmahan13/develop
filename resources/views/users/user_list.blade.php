<div class="table-responsive">
    <table class="table table-striped" st-table="$users.userCollection" st-safe-src="$users.users">
        <thead>
            <tr>
                <th colspan="2"><input st-search placeholder="Búsqueda" class="form-control" type="search"/></th>
                <th colspan="2" />
                <th colspan="2">
                    <button class="btn btn-primary"ng-click="$users.addUser($event)">Crear nuevo usuario</button>
                </th>
            </tr>
            <tr>
                <th></th>
                <th>Dni</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Perfil</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="row in $users.userCollection">
                <td>
                    <users-details user-id="row.id" user="row"></users-details>
                </td>
                <td>{%row.dni%}</td>
                <td>{%row.name%}</td>
                <td>{%row.email%}</td>
                <td>{%row.roles.roles%}</td>
                <td>
                    <button class="btn btn-default" ng-click="$users.delete($event, row.id)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-center">
                    <div st-pagination="" st-items-by-page="10" st-displayed-pages="7"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
