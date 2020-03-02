<div class="modal-header">
	<h5 class="modal-title" id="modal-title">Confirmación</h5>
</div>
<div class="modal-body" id="modal-body">
    <p ng-if="$ctrl.numero != 1">¿Desea facturar los {%$ctrl.numero%} contratos que están en la lista?</p>
    <p ng-if="$ctrl.numero == 1">¿Desea facturar el contrato que está en la lista?</p>
</div>
<div class="modal-footer">
	<button class="btn btn-secondary" type="button" ng-click="$ctrl.confirmar()">Confirmar facturación</button>
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.cancel()">Cancelar</button>
</div>