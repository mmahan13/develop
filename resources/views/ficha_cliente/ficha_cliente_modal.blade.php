<div class="modal-header">
  <h5>Ficha cliente</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>
<form name="editar_cliente" method="post" class="form-horizontal" role="form" id="clienteForm">
<div class="modal-body " id="modal-body" style="padding: 40px;">

            <div class="form-group row">
                  <label style="text-align:right" for="razonsocial" class="col-sm-2 col-form-label">Razon Social</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" name="razonsocial" class="form-control" id="razonsocial"  ng-model="$ctrl.razonsocial" ng-minlength="2" ng-maxlength="60" placeholder="Nombre cliente o empresa" required="required">
                     <p ng-show="editar_cliente.razonsocial.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="editar_cliente.razonsocial.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
                    </div>  
                  <label style="text-align:right" for="cifdni" class="col-sm-2 col-form-label">CIF</label>
                  <div class="col-sm-4" ng-class="{ 'has-error' : editar_cliente.cifdni.$invalid && !editar_cliente.cifdni.$pristine }">
                    <input type="text" name="cifdni" class="form-control" id="cifdni"  ng-model="$ctrl.cifdni" required="required">
                  </div>
                 
            </div>

            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail 1</label>
                  <div class="col-sm-4" ng-class="{'has-error' : editar_cliente.email1.$invalid && !editar_cliente.email1.$pristine }">
                    <input type="email" name="email1" class="form-control" id="email1" ng-model="$ctrl.email1" required="required">
                  </div>
                    <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail 2</label>
                  <div class="col-sm-4" ng-class="{'has-error' : editar_cliente.email2.$invalid && !editar_cliente.email2.$pristine }">
                    <input type="email" name="email2" class="form-control" id="email2"  ng-model="$ctrl.email2"  required="required">
                  </div>
            </div> 

            <div class="form-group row">
              <label style="text-align:right" for="cargo1" class="col-sm-2 col-form-label">Responsable</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="nombre1" class="form-control" id="nombre1"  ng-model="$ctrl.nombre1" ng-minlength="2" ng-maxlength="60"  required="required">
                  <p ng-show="editar_cliente.nombre1.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                  <p ng-show="editar_cliente.nombre1.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
              </div> 
              <label style="text-align:right" for="cargo1" class="col-sm-2 col-form-label">Responsable</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="cargo1" class="form-control" id="cargo1"  ng-model="$ctrl.cargo1" ng-minlength="2" ng-maxlength="60"  required="required">
                  <p ng-show="editar_cliente.cargo1.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                  <p ng-show="editar_cliente.cargo1.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
              </div>  
            </div>  
            <div class="form-group row">
              <label style="text-align:right" for="cargo1" class="col-sm-2 col-form-label">Entidad</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="codigobanco" class="form-control" id="codigobanco"  ng-model="$ctrl.codigobanco" ng-minlength="2" ng-maxlength="60"  required="required">
                  <p ng-show="editar_cliente.codigobanco.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                  <p ng-show="editar_cliente.codigobanco.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
              </div> 
              <label style="text-align:right" for="cargo1" class="col-sm-2 col-form-label">IBAN</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="iban" class="form-control" id="iban"  ng-model="$ctrl.iban" ng-minlength="2" ng-maxlength="60"  required="required">
                  <p ng-show="editar_cliente.iban.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                  <p ng-show="editar_cliente.iban.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
              </div>  
            </div>  
            
     

     
        
      <div class="form-group row">
        <label for="inputPassword" class="col-sm-12 col-form-label">Domicilios</label>
        <div class="table-responsive">
          <table class="table table-hover"st-table="lista" st-safe-src="$ctrl.domicilios">
              <tbody>
                <tr ng-repeat="row in lista" >
                     <td>{%row.tipodomicilio%}</td>
                     <td>{%row.domicilio%}</td>
                     <td>{%row.codigopostal%}</td>
                     <td>{%row.poblacion%}</td>
                     <td>{%row.provincia%}</td>
                     <td>{%row.telefono%}</td>
                </tr>
              </tbody>
          </table>
        </div>
       </div>
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-12 col-form-label">Facturas</label>   
    <div class="table-responsive">
    <table class="table table-hover" st-table="facturas" st-safe-src="$ctrl.lista_facturas_cliente">
        <thead>
            <tr>
                <th st-sort="fechafactura">Fecha</th>
                <th style="text-align: right; width: 8%;" st-sort="numerofactura">Factura</th>
                <th style="text-align: right;" st-sort="importeliquido">Total</th>
            </tr>   
        </thead>
        <tbody>
            <tr ng-repeat="row in facturas" ng-click="$ctrl.verFactura($event, row)" style="cursor: pointer;">
                <td>{% row.fechafactura%}</td>
                <td style="text-align: right;">{% row.numerofactura%}</td>
                <td style="text-align: right;">{% row.importeliquido |number:2%}</td>
            </tr>
            <tr>
                <th colspan="7" style="text-align: right;">Total: {%$ctrl.total | number:2%}</th>
            </tr>
        </tbody>
    </table>
  </div>
</div>
       <!-- <div class="table-responsive">
        <table class="table table-hover">
        <tbody>
        <tr>
          <td style="cursor: pointer; text-align: center" ng-click="$ctrl.listadoDeFacturas($event)">Facturas</td>
          <td style="cursor: pointer; text-align: center" ng-click="$ctrl.compra($event)">Artículos</td>
          <td style="cursor: pointer; text-align: center" ng-click="$ctrl.estadisticas($event)">Datos</td>
        </tr>
        </tbody>
      </table>           
      </div>-->
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" ng-disabled="editar_cliente.$invalid" ng-click="$ctrl.guardar_cambios($event)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
</form>

