<p ng-if="$lCtrl.lista_gastos.length == 0" style="font-size: 20px;">No hay Gastos para mostrar</p>
<div class="table-responsive" ng-if="$lCtrl.lista_gastos.length > 0">
<table class="table table-hover" style="cursor: pointer;" st-table="lista_gastos" st-safe-src="$lCtrl.lista_gastos">
    <thead>
        <tr> 
            <th colspan="5">
                <input st-search placeholder="Buscar gasto..." class="form-control form-control-sm" type="search"/>
            </th>
            <th></th>
        </tr>
        <tr>
            <th st-sort="fechapresupuesto">Fecha</th>
            <th style=" text-align: right;" st-sort="numerogasto">Gasto</th>
            <th st-sort="razonsocial">Proveedor</th>
            <th st-sort="cifdni">CIF</th>
            <th st-sort="descripcionfactura">Descripción</th>
            <th style="text-align: right;" st-sort="importeliquido">Total</th>
        </tr>     
    </thead>
    <tbody>
        <tr ng-repeat="row in lista_gastos" ng-click="$lCtrl.verGasto($event, row)">
            <td>{%row.fechafactura%}</td>
            <td style="text-align: right;">{%row.numerogasto%}</td>
            <td>{%row.razonsocial%}</td>
            <td>{%row.cifdni%}</td>
            <td>{%row.descripcionfactura%}</td>
            <td style="text-align: right;">{%row.importeliquido |number:2%}</td>
        </tr>
    </tbody>

</table>
</div>