<form name="roleForm" action="" method="post" class="form-horizontal" role="form"
      ng-submit="$modalDetails.sendForm($event, roleForm)">
    <div class="row">
        <div class="col-sm-6">
            <div class="row form-group">
                <label for="name" class="col-sm-12 control-label">Nombre</label>
                <div class="col-sm-12" ng-class="{ 'has-error' : roleForm.name.$invalid && !roleForm.name.$pristine }">
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        title="Nombre"
                        required="required"
                        ng-model="$modalDetails.name"
                        ng-trim="false"
                        restrict-field="name" />
                    <p ng-show="roleForm.name.$error.name" class="help-block">El nombre no puede contener espacios.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row form-group">
                <label for="description" class="col-sm-12 control-label">Descripción</label>
                <div class="col-sm-12" ng-class="{ 'has-error' : roleForm.description.$invalid && !roleForm.description.$pristine }">
                    <input
                        type="text"
                        name="description"
                        id="description"
                        class="form-control"
                        title="Descripción"
                        required="required"
                        ng-model="$modalDetails.description"
                        ng-minlength="3"
                        ng-maxlength="50" />
                    <p ng-show="roleForm.description.$error.minlength" class="help-block">El nombre es muy corto.</p>
                    <p ng-show="roleForm.description.$error.maxlength" class="help-block">El nombre es muy largo.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-md-3">
            <div class="form-group">
                <label for="roles" class="col-sm-12 control-label">Permisos</label>
                <div class="col-sm-12">
                    <div
                        isteven-multi-select
                        input-model="$modalDetails.permissions"
                        output-model="$modalDetails.selectedPermissions"
                        button-label="Description"
                        item-label="Description"
                        tick-property="selected"
                        max-labels="1"
                        translation="$modalDetails.localLang" />
                    <input type="hidden" ng-model="$modalDetails.selectedPermissions" ng-minlength="1" name="permissionSelection">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 offset-md-1">
            <button type="submit" class="btn btn-primary" ng-disabled="roleForm.$invalid">Enviar</button>
        </div>
    </div>
</form>
