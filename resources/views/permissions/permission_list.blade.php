<div class="table-responsive">
    <table class="table table-striped" st-table="$permissions.permissionsCollection" st-safe-src="$permissions.permissions">
        <thead>
        <tr>
            <th colspan="3"><input st-search placeholder="Búsqueda" class="form-control" type="search"/></th>
            <th colspan="1"/>
            <th colspan="2">
                <button class="btn btn-primary"ng-click="$permissions.addPermission($event)">Crear nuevo permiso</button>
            </th>
        </tr>
        <tr>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Módulo</th>
            <th>Descripción</th>
            <th>ruta</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="row in $permissions.permissionsCollection">
            <td>
                <permissions-details permission-id="row.id" permission="row"></permissions-details>
            </td>
            <td>{%row.id%}</td>
            <td>{%row.name%}</td>
            <td>{%row.module%}</td>
            <td>{%row.description%}</td>
            <td>{%row.route%}</td>
            <td>
                <button
                    class="btn btn-default"
                    ng-click="$permissions.delete($event, row.id)">
                        <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-center">
                <div st-pagination="" st-items-by-page="10" st-displayed-pages="7"></div>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
