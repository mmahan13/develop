<div class="modal-header">
    <h3 class="modal-title" ng-if="$modalDetails.name" id="modal-title">añadir usuario</h3>
    <h3 class="modal-title" ng-if="!$modalDetails.name" id="modal-title">Usuario: {%$modalDetails.name%}</h3>
</div>
<div class="modal-body" id="modal-body">
    <div class="container-fluid">
        @include('users.user_form')
    </div>
</div>
