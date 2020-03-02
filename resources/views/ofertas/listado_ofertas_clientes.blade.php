<div class="col-lg-10 panel hide" id="listado_ofertas_clientes">
    <div class="card">
        <div class="card-header">
            <h4 class="">Listado Ofertas</h4>
        </div>
        <div class="card-body">
            <lista-ofertas-clientes></lista-ofertas-clientes>
        </div>
    </div>
</div>

<script type="text/ng-template" id="lista-ofertas-table.html">
        @include('ofertas.lista_ofertas_table')
</script>
<script type="text/ng-template" id="ver-oferta-modal.html">
        @include('ofertas.ver_oferta_modal')
</script>
{{--<script type="text/ng-template" id="ficha-cliente-modal.html">
        @include('ficha_cliente.ficha_cliente_modal')
</script>
<script type="text/ng-template" id="listar-facturas-cliente-modal.html">
        @include('clientes.listar_facturas_cliente_modal')
</script>
<script type="text/ng-template" id="ver-factura-modal.html">
        @include('factura.ver_factura_modal')
</script>
<script type="text/ng-template" id="estadisticas-cliente-modal.html">
        @include('clientes.estadisticas_cliente_modal')
</script>
<script type="text/ng-template" id="detalle-trimestre-facturas-modal.html">
        @include('clientes.detalle_trimestre_facturas_modal')
</script>
<script type="text/ng-template" id="listar-articulos-comprados-modal.html">
        @include('clientes.listar_articulos_comprados_modal')
</script>
--}}