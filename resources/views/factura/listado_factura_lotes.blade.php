<div class="col-lg-10 panel hide" id="listado_factura_lotes">
    <div class="card">
        <div class="card-header">
            <h4 class="">Lote facturas</h4>
        </div>
        <div class="card-body">
             <listado-facturas-lotes></listado-facturas-lotes>
        </div>
    </div>
</div>

<script type="text/ng-template" id="lote-facturas-table.html">
        @include('factura.lote_facturas_table')
</script>
{{--
<script type="text/ng-template" id="ver-factura-modal.html">
        @include('factura.ver_factura_modal')
</script>
--}}