<div class="modal-header">
  <h5>Editar producto</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>

<form name="crear_producto" method="post" class="form-horizontal" role="form" id="productoForm">
<div class="modal-body " id="modal-body" style="padding: 40px;">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Referencia</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" name="ref" class="form-control" id="ref" ng-minlength="2" ng-maxlength="9"  ng-model="$ctrl.ref" placeholder="Numero referencia producto"  required="required">
                      <p ng-show="crear_producto.ref.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="crear_producto.ref.$error.maxlength" class="help-block">Máximo 9 caracteres</p>
                  </div>
            </div>
        </div>
        <div class="col-sm-6">    
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Producto</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="producto" class="form-control" id="producto"  ng-model="$ctrl.producto" ng-minlength="2" ng-maxlength="150" placeholder="Nombre producto" required="required">
                     <p ng-show="crear_producto.producto.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="crear_producto.producto.$error.maxlength" class="help-block">Máximo 150 caracteres</p>
                  </div>
            </div>
        </div> 

        <div class="col-sm-6">
            <div class="form-group row">
                <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">% IVA</label>
                <div class="col-sm-10">
                  <select class="form-control" name="tipoiva" ng-options="option.poriva for option in $ctrl.Tipos track by option.id" ng-model="$ctrl.ivas.poriva"></select>
                </div>
            </div>
        </div>
        
    </div>

</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
 <button  type="button" class="btn btn-secondary" ng-disabled="crear_producto.$invalid" ng-click="$ctrl.actualizarArticulo($event)">Acturalizar</button>
</div>
</form>

