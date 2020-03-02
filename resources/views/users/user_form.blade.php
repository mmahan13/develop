<form
    name="userForm"
    action=""
    method="post"
    class="form-horizontal"
    role="form"
    ng-submit="$modalDetails.sendForm($event, userForm)">
        @csrf
        <div calss="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="dni" class="col-sm-12 control-label">DNI</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : userForm.dni.$invalid && !userForm.dni.$pristine }">
                            <input
                                type="text"
                                name="dni"
                                id="dni"
                                class="form-control"
                                title="Dni"
                                required="required"
                                ng-model="$modalDetails.dni"
                                validnif />
                            <p ng-show="userForm.dni.$error.dni" class="help-block">El documento está en uso actualmente.</p>
                            <p ng-show="userForm.dni.$error.validnif" class="help-block">Formato de DNI no válido.</p>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-sm-12 control-label">Nombre</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : userForm.name.$invalid && !userForm.name.$pristine }">
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                title="Nombre"
                                required="required"
                                ng-model="$modalDetails.name"
                                ng-minlength="3"
                                ng-maxlength="120" />
                            <p ng-show="userForm.name.$error.minlength" class="help-block">El nombre es muy corto.</p>
                            <p ng-show="userForm.name.$error.maxlength" class="help-block">El nombre es muy largo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div calss="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="email" class="col-sm-12 control-label">Correo</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.email.$pristine }">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                title="Correo"
                                required="required"
                                ng-model="$modalDetails.email" />
                            <p
                                ng-show="userForm.email.$invalid && !userForm.email.$pristine"
                                class="help-block">
                                El email está en uso actualmente o no es una dirección valida.
                            </p>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="roles" class="col-sm-12 control-label">Perfiles</label>
                        <div class="col-sm-12">
                            <div
                                isteven-multi-select
                                input-model="$modalDetails.roles"
                                output-model="$modalDetails.selectedRoles"
                                button-label="description"
                                item-label="description"
                                tick-property="selected"
                                max-labels="1"
                                translation="$modalDetails.localLang" ></div>
                            <input
                                type="hidden"
                                ng-model="$modalDetails.selectedRoles"
                                ng-minlength="1"
                                name="roleSelection" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div calss="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="password" class="col-sm-12 control-label">Contraseña</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : userForm.password.$invalid && !userForm.password.$pristine }">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                ng-model="$modalDetails.password"
                                required="required"
                                ng-minlength="4" />
                            <p ng-show="userForm.password.$error.minlength" class="help-block">La clave es muy corta.</p>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="confirm" class="col-sm-12 control-label">Confirmar</label>
                        <div class="col-sm-12" ng-class="{ 'has-error' : userForm.confirm.$invalid && !userForm.confirm.$pristine }">
                            <input
                                type="password"
                                name="confirm"
                                id="confirm"
                                class="form-control"
                                ng-model="$modalDetails.confirm"
                                required="required" />
                            <p ng-show="userForm.confirm.$error.passMatch" class="help-block">La claves no coinciden.</p>
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
                            <button type="submit" class="btn btn-primary" ng-disabled="userForm.$invalid">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
