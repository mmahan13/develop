<div class="col-lg-10 panel hide" id="listado_proveedores">
    <div class="card">
        <div class="card-header">
            <h4 class="">Proveedores</h4>
        </div>
        <div class="card-body">
             <lista-proveedores></lista-proveedores>
        </div>
    </div>
</div>
<script type="text/ng-template" id="lista-proveedores-table.html">
        @include('compras.lista_proveedores_table')
</script>
<script type="text/ng-template" id="listar-presupuestos-proveedor-modal.html">
        @include('compras.listar_presupuestos_proveedor_modal')
</script>
<script type="text/ng-template" id="ficha-proveedor-modal.html">
        @include('ficha_proveedor.ficha_proveedor_modal')
</script>
<script type="text/ng-template" id="lista-articulos-proveedor-modal.html">
        @include('compras.lista_articulos_proveedor_modal')
</script>