<div class="col-lg-10 panel hide" id="pendientes_facturacion">
    <div class="card">
        <div class="card-header">
            <h4 class="">Facturar contratos</h4>
        </div>
        <div class="card-body">
             <pendientes-facturacion></pendientes-facturacion>
        </div>
    </div>
</div>
<script type="text/ng-template" id="pendientes-facturacion-table.html">
        @include('contratos.pendientes_facturacion_table')
</script>
<script type="text/ng-template" id="detalle-a-facturar-modal.html">
        @include('contratos.detalle_a_facturar_modal')
</script>
<script type="text/ng-template" id="conformacion-facturar-todo-modal.html">
        @include('modals.conformacion-facturar-todo-modal')
</script>