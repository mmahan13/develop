<form
    name="permissionForm"
    action=""
    method="post"
    class="form-horizontal"
    role="form"
    ng-submit="$modalDetails.sendForm($event, permissionForm)">
        @csrf
        <div calss="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-sm-12 control-label">Tipo</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : permissionForm.name.$invalid && !permissionForm.name.$pristine }">
                            <input
                                name="text"
                                name="name"
                                id="name"
                                class="form-control"
                                title="Tipo"
                                required="required"
                                ng-model="$modalDetails.name" />
                            <p ng-show="permissionForm.name.$error.name" class="help-block">El documento está en uso actualmente.</p>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="module" class="col-sm-12 control-label">Módulo</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : permissionForm.module.$invalid && !permissionForm.module.$pristine }">
                            <input
                                type="text"
                                name="module"
                                class="form-control"
                                title="Módulo"
                                required="required"
                                ng-model="$modalDetails.module"
                                ng-minlength="3"
                                ng-maxlength="120" />
                            <p ng-show="permissionForm.module.$error.minlength" class="help-block">El nombre es muy corto.</p>
                            <p ng-show="permissionForm.module.$error.maxlength" class="help-block">El nombre es muy largo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div calss="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="description" class="col-sm-12 control-label">Descripción</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : permissionForm.description.$invalid && !permissionForm.description.$pristine }">
                            <input
                                type="description"
                                name="description"
                                id="description"
                                class="form-control"
                                title="Descripción"
                                required="required"
                                ng-model="$modalDetails.description" />
                            <p
                                ng-show="permissionForm.description.$invalid && !permissionForm.description.$pristine"
                                class="help-block">
                                El description está en uso actualmente o no es una dirección valida.
                            </p>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="route" class="col-sm-12 control-label">Ruta</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : permissionForm.route.$invalid && !permissionForm.route.$pristine }">
                            <input
                                type="route"
                                name="route"
                                id="route"
                                class="form-control"
                                title="Ruta"
                                required="required"
                                ng-model="$modalDetails.route" />
                            <p
                                ng-show="permissionForm.route.$invalid && !permissionForm.route.$pristine"
                                class="help-block">
                                El route está en uso actualmente o no es una dirección valida.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-10 offset-md-1">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" ng-disabled="permissionForm.$invalid">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
