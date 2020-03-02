<div class="modal-header">
	<h5 class="modal-title" id="modal-title">Descripción linea</h5>
</div>
<div class="modal-body" id="modal-body">
    <div class="form-group">
     <textarea class="form-control rounded-0" id="descripcionlinea" ng-model="$ctrl.descripcionlinea" rows="3" maxlength="150"></textarea>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" ng-click="$ctrl.cancel()">aceptar</button>
</div>