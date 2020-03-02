<div class="col-lg-10 panel hide" id="listado_usuarios">
    <div class="card">
        <div class="card-header">
            <h4 class="">Gastos proveedor</h4>
        </div>
        <div class="card-body">
             <listado-gastos-proveedores></listado-gastos-proveedores>
        </div>
    </div>
</div>

<script type="text/ng-template" id="listado-gastos.html">
        @include('compras.listado_gastos')
</script>
<script type="text/ng-template" id="ver-gasto-modal.html">
        @include('compras.ver_gasto_modal')
</script>