<div class="modal-header">
    <h3 class="modal-title" ng-if="$modalDetails.name" id="modal-title">añadir permiso de ruta</h3>
</div>
<div class="modal-body" id="modal-body">
    <div class="container-fluid">
        @include('permissions.permission_form')
    </div>
</div>
