
<div class="col-lg-10 panel hide" id="listado_facturas_clientes">
    <div class="card">
        <div class="card-header">
            <h4 class="">Listado Facturas</h4>
        </div>
        <div class="card-body">
             <listado-facturas-clientes></listado-facturas-clientes>
        </div>
    </div>
</div>
<script type="text/ng-template" id="facturas-table.html">
        @include('factura.facturas_table')
</script>

<script type="text/ng-template" id="ver-factura-modal.html">
        @include('factura.ver_factura_modal')
</script>


