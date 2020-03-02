<div class="modal-header">
  <h4>Información financiera</h4>
</div>
<div class="modal-body " id="modal-body" >
    <div class="table-responsive">
        <table class="table" st-table="datos_financieros" st-safe-src="$ctrl.datos_financieros">
        <thead>
            <tr>
                <th style="text-align: right;">Base imponible €</th>
                <th style="text-align: right;">Importe coste €</th>
                <th style="text-align: right;">Margen beneficio €</th>
                <th style="text-align: right;">Porcentaje beneficio %</th>
            </tr>
        </thead>
        <tbody>
                <tr ng-repeat="row in datos_financieros">
                    <td style="text-align: right;">{%row.baseimponible | number:2%}</td>
                    <td style="text-align: right;">{%row.importecoste | number:2%}</td>
                    <td style="text-align: right;">{%row.margenbeneficio | number:2%}</td>
                    <td style="text-align: right;">{%row.pormargenbeneficio |number:0%}</td>
                </tr>
        </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>

