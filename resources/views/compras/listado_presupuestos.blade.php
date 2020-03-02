
<div class="col-lg-10 panel hide" id="listado_facturas_proveedores">
    <div class="card">
        <div class="card-header">
            <h4 class="">Facturas proveedor</h4>
        </div>
        <div class="card-body">
             <listado-presupuestos></listado-presupuestos>
        </div>
    </div>
</div>

<script type="text/ng-template" id="presupuestos-table.html">
        @include('compras.presupuestos_table')
</script>
<script type="text/ng-template" id="ver-presupuesto-modal.html">
        @include('compras.ver_presupuesto_modal')
</script>
<script type="text/ng-template" id="estadisticas-proveedor-modal.html">
        @include('compras.estadisticas_proveedor_modal')
</script>
<script type="text/ng-template" id="nuevo-proveedor-modal.html">
        @include('compras.nuevo_proveedor_modal')
</script>
<script type="text/ng-template" id="detalle-trimestre-proveedor-modal-modal.html">
        @include('compras.detalle_trimestre_proveedor_modal')
</script>

<script type="text/ng-template" id="ver-trimestre-proveedores-total-modal.html">
        @include('compras.ver_trimestre_proveedores_total_modal')
</script>

<script type="text/ng-template" id="leer-mas-modal.html">
        @include('modals.leer_mas_modal')
</script>