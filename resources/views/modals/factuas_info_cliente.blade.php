<div class="modal-header">
	<h5 class="modal-title" id="modal-title">Facturas</h5>
</div>
<div class="modal-body" id="modal-body">
    <div class="table-responsive">
    <table class="table table-striped" st-table="$ctrl.facturasClientes" st-safe-src="$ctrl.facturasClientes">
        <thead>
        <tr>
            <th colspan="3"><input st-search placeholder="Búsqueda" class="form-control form-control-sm" type="search"/></th>
            <th colspan="3">
                <!--<button class="btn btn-primary"ng-click="$permissions.addPermission($event)">Crear nuevo permiso</button>-->
            </th>
        </tr>
        <tr>
        <tr>
            <th>Fecha</th>
            <th>Factura</th>
            <th>Base imponible</th>
           	<th>IVA</th>
           	<th>Retenciones</th>
           	<th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="row in $ctrl.facturasClientes">
            <td>{%row.fecha%}</td>
            <td>{%row.prefijo%}-{%row.idfactura%}-{%row.sufijo%}</td>
            <td>{%row.base_imponible%}</td>
            <td>{%row.total_iva%}</td>
            <td>{%row.total_retenciones%}</td>
            <td>{%row.total_factura%}</td>
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
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.cancel()">Cerrar</button>
</div>