<div class="col-lg-10 panel hide" id="lista_articulos">
    <div class="card-new">
        <div class="card-header-new">
            <h4 class="">Mis productos</h4>
        </div>
        <div class="card-body-new">
           <lista-articulos></lista-articulos>
        </div>
    </div>
</div>

<script type="text/ng-template" id="editar-articulo-modal.html">
        @include('articulos.editar_articulo_modal')
</script>
<script type="text/ng-template" id="nuevo-articulo-modal.html">
        @include('articulos.nuevo_articulo_modal')
</script>
 