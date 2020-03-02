<div class="modal-header">
    <h3 class="modal-title" ng-if="$modalDetails.name" id="modal-title">añadir permiso de rura</h3>
    <h3 class="modal-title" ng-if="!$modalDetails.name" id="modal-title">Permiso: {%$modalDetails.description%}</h3>
</div>
<div class="modal-body" id="modal-body">
    <div class="container-fluid">
        @include('permissions.permission_form')
    </div>
</div>
