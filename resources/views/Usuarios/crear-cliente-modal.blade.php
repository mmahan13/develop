<div class="modal-header">
  <h5>Nuevo cliente</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)"><span aria-hidden="true">&times;</span></button>
</div>
<form name="editar_cliente" method="post" class="form-horizontal" role="form" id="clienteForm">
<div class="modal-body " id="modal-body" style="padding: 40px;">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" class="form-control" id="nombre"  ng-model="$ctrl.nombre" ng-minlength="2" ng-maxlength="20" placeholder="Nombre cliente" required="required">
                      <p ng-show="editar_cliente.nombre.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="editar_cliente.nombre.$error.maxlength" class="help-block">Máximo 30 caracteres</p>
                  </div>
            </div>
        </div>
        <div class="col-sm-6">    
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Apellidos</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="apellidos" class="form-control" id="apellidos"  ng-model="$ctrl.apellidos" ng-minlength="2" ng-maxlength="20" placeholder="Apellidos cliente" required="required">
                     <p ng-show="editar_cliente.apellidos.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="editar_cliente.apellidos.$error.maxlength" class="help-block">Máximo 30 caracteres</p>
                  </div>
            </div>
        </div> 

        <div class="col-sm-6">
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">CIF</label>
                  <div class="col-sm-10" ng-class="{ 'has-error' : editar_cliente.dni.$invalid && !editar_cliente.dni.$pristine }">
                    <input type="text" name="dni" class="form-control" id="dni" ng-model="$ctrl.dni" placeholder="DNI cliente" required="required">
                  </div>
            </div>
        </div>
        <div class="col-sm-6">      
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail</label>
                  <div class="col-sm-10" ng-class="{'has-error' : editar_cliente.email.$invalid && !editar_cliente.email.$pristine }">
                    <input type="email" name="email" class="form-control" id="email"  ng-model="$ctrl.email" placeholder="ejemplo@dominio.com" required="required">
                  </div>
            </div>  
        </div>
        <div class="col-sm-6">    
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Teléfono</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefono" class="form-control" id="telefono"  ng-model="$ctrl.telefono" ng-minlength="1" ng-maxlength="9" placeholder="Teléfono cliente" required="required">
                     <p ng-show="editar_cliente.telefono.$error.minlength" class="help-block">Mínimo 1 caracteres</p>
                      <p ng-show="editar_cliente.telefono.$error.maxlength" class="help-block">Máximo 8 caracteres</p>
                  </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Dirección</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="direccion" class="form-control" id="direccion"  ng-model="$ctrl.direccion" ng-minlength="2" ng-maxlength="255" placeholder="Dirección cliente" required="required">
                     <p ng-show="editar_cliente.direccion.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="editar_cliente.direccion.$error.maxlength" class="help-block">Máximo 255 caracteres</p>
                  </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
 <button  type="button" class="btn btn-secondary" ng-disabled="editar_cliente.$invalid" ng-click="$ctrl.crearCliente($event)">Guardar</button>
</div>
</form>

