<div class="col-lg-10 panel hide" id="listado_usuarios">
    <div class="card-new">
        <div class="card-header-new">
            <h4 class="">Mis clientes</h4>
        </div>
        <div class="card-body-new">
             <listado-usuarios></listado-usuarios>
        </div>
    </div>
</div>

<script type="text/ng-template" id="tabla_listado_usuarios.html">
        @include('Usuarios.tabla_listado_usuarios')
</script>
<script type="text/ng-template" id="editar-cliente.html">
        @include('Usuarios.editar-cliente-modal')
</script>
<script type="text/ng-template" id="crear-cliente.html">
        @include('Usuarios.crear-cliente-modal')
</script>
<script type="text/ng-template" id="listado-facturas-cliente.html">
        @include('Usuarios.listado-facturas-cliente')
</script>

