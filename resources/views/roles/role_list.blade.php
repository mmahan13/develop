<div class="table-responsive">
    <table class="table table-striped" st-table="$roles.roleCollection" st-safe-src="$roles.roles">
        <thead>
            <tr>
                <th colspan="2"><input st-search placeholder="Búsqueda" class="form-control" type="search"/></th>
                <th/>
                <th/>
                <th>
                    <button class="btn btn-primary"ng-click="$roles.addRole($event)">Crear nuevo usuario</button>
                </th>
            </tr>
            <tr>
            <tr>
                <th style="width: 30px"></th>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th style="width: 30px"></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="row in $roles.roleCollection">
                <td>
                    <roles-details role-id="row.id" role="row"></roles-details>
                </td>
                <td>{%row.id%}</td>
                <td>{%row.name%}</td>
                <td>{%row.description%}</td>
                <td>
                    <button class="btn btn-default" ng-click="$roles.delete($event, row.id)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <div st-pagination="" st-items-by-page="10" st-displayed-pages="7"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
