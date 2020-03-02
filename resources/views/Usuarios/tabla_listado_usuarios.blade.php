<button type="button" class="btn btn-success float-right btn-sm" style="margin-right: 2rem;" ng-click="$lCtrl.nuevoCliente($event)">Nuevo Cliente</button>
<button id='toggleFiltering' style="margin-right: 0.5rem;" ng-click="$lCtrl.mostrarFlitrosTablas()" class="btn btn-info float-right  btn-sm"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>

<div class="table-responsive">
 <div id="grid1" ui-grid="$lCtrl.tableOpts"  ui-grid-auto-resize  ui-grid-resize-columns  class="grid"></div>
</div>