<div class="modal-header">
  <h5>Facturas</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body " id="modal-body" style="padding: 40px;">
<div class="table-responsive">
 <div id="grid1" ui-grid="$ctrl.tableOpts"  ui-grid-auto-resize  ui-grid-resize-columns  class="grid"></div>
</div>

</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
 <button ng-if="$ctrl.modaltitle == 'Editar cliente'" type="button" class="btn btn-secondary" ng-disabled="editar_cliente.$invalid" ng-click="$ctrl.guardarCambios($event)">Actualizar</button>
 <button ng-if="$ctrl.modaltitle == 'Nuevo cliente'" type="button" class="btn btn-secondary" ng-disabled="editar_cliente.$invalid" ng-click="$ctrl.crearCliente($event)">Guardar</button>
</div>


