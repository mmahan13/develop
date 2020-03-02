
<div class="col-lg-10 panel hide" id="listado_contratos">
    <div class="card">
        <div class="card-header">
            <h4 class="">Listado contratos</h4>
        </div>
        <div class="card-body">
             <listado-contratos></listado-contratos>
        </div>
    </div>
</div>
<script type="text/ng-template" id="contratos-table.html">
        @include('contratos.contratos_table')
</script>
<script type="text/ng-template" id="datos-contrato-modal.html">
        @include('contratos.datos_contrato_modal')
</script>
<script type="text/ng-template" id="plan-contrato-modal.html">
        @include('contratos.plan_contrato_modal')
</script>
<script type="text/ng-template" id="detalle-plan-contrato-modal.html">
        @include('contratos.detalle-plan-contrato-modal')
</script>
<script type="text/ng-template" id="add-lineas-contrato-modal.html">
        @include('contratos.add_lineas_contrato_modal')
</script>
<script type="text/ng-template" id="nuevo-contrato-modal.html">
        @include('contratos.nuevo_contrato_modal')
</script>
<script type="text/ng-template" id="editar-lineas-contrato-modal.html">
        @include('contratos.editar_lineas_contrato_modal')
</script>
<script type="text/ng-template" id="editar-cabecera-contrato-modal.html">
        @include('contratos.editar_cabecera_contrato_modal')
</script>
<script type="text/ng-template" id="generar-factura-desde-contrato.html">
        @include('contratos.generar_factura_desde_contrato')
</script>
