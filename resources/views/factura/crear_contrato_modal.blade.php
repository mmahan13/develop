<div class="modal-header">
	<h5 class="modal-title" id="modal-title">Generar contrato</h5>
</div>
<div class="modal-body" id="modal-body">
       <table class="table">
            <thead>
                <tr> 
                    <th>Periodicidad</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in datos_factura">
                     <!--<td><cambiar-fecha-component cambiar-fecha="$ctrl.fecha_inicio" desde-donde="3"></cambiar-fecha-component></td>
                     <td><cambiar-fecha-component cambiar-fecha="$ctrl.fecha_fin" desde-donde="4"></cambiar-fecha-component></td>-->
                     <td><select style="height:31px;" class="form-control" name="tipo" ng-options="option.tipo for option in $ctrl.TiposPlan track by option.id" ng-model="$ctrl.plan.tipo"></select></td>
                     <td><select style="height:31px;" class="form-control" name="tipo" ng-options="option.tipo for option in $ctrl.TiposMeses track by option.id" ng-model="$ctrl.duracion.tipo"></select></td>
                </tr>
            </tbody>
        </table>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.generarContrato()">Aceptar</button>
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.cancel()">Cerrar</button>
</div>