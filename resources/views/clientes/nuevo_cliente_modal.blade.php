<div class="modal-header">
  <h4> <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Cliente</h4>
</div>
<form name="nuevo_cliente" method="post" class="form-horizontal" role="form" id="clienteForm">
<div class="modal-body " id="modal-body" style="padding: 25px;" ng-hide="$ctrl.cliente.length > 0">
    <!--
        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Logo</label>       
            <div class="col-sm-10">
                 <input type="file" class="form-control" ngf-select ng-model="file" name="file" ngf-max-size="600kb">
            </div>
        </div> -->
        <p style="margin-left:70px;font-size:17px;">Cliente:</p>
        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Razon Social</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="razonsocial" class="form-control" id="razonsocial"  ng-model="$ctrl.razonsocial" ng-minlength="2" ng-maxlength="40" placeholder="Nombre empresa" required="required">
               <p ng-show="nuevo_cliente.razonsocial.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                <p ng-show="nuevo_cliente.razonsocial.$error.maxlength" class="help-block">Máximo 40 caracteres</p>
            </div>
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">CIF</label>
            <div class="col-sm-4" ng-class="{ 'has-error' : nuevo_cliente.CifDni.$invalid && !nuevo_cliente.CifDni.$pristine }">
              <input type="text" name="CifDni" class="form-control" id="CifDni"  ng-model="$ctrl.cifdni" required="required">
            </div>
        </div>

        <div class="form-group row">
             
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Responsable</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.nombre1.$invalid && !nuevo_cliente.nombre1.$pristine }">
              <input type="text" name="nombre1" class="form-control" id="nombre1"  ng-model="$ctrl.nombre1" required="required">
            </div>
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Cargo</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.cargo1.$invalid && !nuevo_cliente.cargo1.$pristine }">
              <input type="text" name="cargo1" class="form-control" id="cargo1"  ng-model="$ctrl.cargo1" required="required">
            </div>
        </div>
        <div class="form-group row">
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail 1</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.email1.$invalid && !nuevo_cliente.email1.$pristine }">
              <input type="email" name="email1" class="form-control" id="email1"  ng-model="$ctrl.email1" placeholder="email1@dominio.com" required="required">
            </div>
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail 2</label>
            <div class="col-sm-4" >
              <input type="email" name="email2" class="form-control" id="email2"  ng-model="$ctrl.email2" placeholder="email2@dominio.com">
            </div>
        </div>

        <div class="form-group row">  
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Nº Entidad</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.codigobanco.$invalid && !nuevo_cliente.codigobanco.$pristine }">
              <input type="text" name="codigobanco" class="form-control" id="codigobanco"  ng-model="$ctrl.codigobanco" ng-minlength="4" ng-maxlength="4">
              <p ng-show="nuevo_cliente.codigobanco.$error.minlength" class="help-block">Mínimo 4 caracteres</p>
              <p ng-show="nuevo_cliente.codigobanco.$error.maxlength" class="help-block">Máximo 4 caracteres</p>
            </div>
            <label style="text-align:right" for="iban" class="col-sm-2 col-form-label">Iban</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.iban.$invalid && !nuevo_cliente.iban.$pristine }">
              <input type="text" name="iban" class="form-control" id="iban" ng-model="$ctrl.iban" ng-minlength="24" ng-maxlength="24" placeholder="ES0000000000000000000000">
              <p ng-show="nuevo_cliente.iban.$error.minlength" class="help-block">Mínimo 24 caracteres</p>
              <p ng-show="nuevo_cliente.iban.$error.maxlength" class="help-block">Máximo 24 caracteres</p>
            </div>
        </div>


</div>
<div class="modal-body " id="modal-body" style="padding: 25px;" ng-if="$ctrl.cliente.length > 0">
       <p style="margin-left:70px;font-size:17px;">Domicilio:</p>
       <div class="form-group row">
          <label style="text-align:right" for="sigla" class="col-sm-2 col-form-label">Tipo Vía</label>
          <div class="col-sm-1">
             <select class="form-control" name="sigla" ng-model="$ctrl.tipovia.sigla" ng-options="option.sigla for option in $ctrl.via track by option.id"></select> 
          
          </div>

            <label style="text-align:right" for="viapublica" class="col-sm-2 col-form-label">Vía pública</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="viapublica" ng-minlength="2" ng-maxlength="60" ng-model="$ctrl.viapublica"  required="required" placeholder="Nombre de la calle">
              <p ng-show="nuevo_cliente.viapublica.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                <p ng-show="nuevo_cliente.viapublica.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
            </div>

          <label style="text-align:right" for="numero1" class="col-sm-1 col-form-label">Nº</label>
          <div class="col-sm-2">
              <input type="number" class="form-control" name="numero1" ng-minlength="1" ng-maxlength="15" ng-model="$ctrl.numero1" placeholder="Nº" required="required">
              <p ng-show="nuevo_cliente.numero1.$error.minlength" class="help-block">Mínimo 1 caracteres</p>
              <p ng-show="nuevo_cliente.numero1.$error.maxlength" class="help-block">Máximo 10 caracteres</p>
          </div>

       </div>

       
       <div class="form-group row">
        <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">CP</label>
            <div class="col-sm-4">
              <div angucomplete-alt
               id="cp_autocomplete"
               placeholder="Buscar codigo postal"
               selected-object="$ctrl.currentProvincia"
               pause="100"
               selected-object="cp_autocomplete"
               local-data="$ctrl.codigos_postales"
               search-fields="codigopostalid,poblacion"
               title-field="codigopostalid"
               minlength="3"
               text-searching="Buscando cp..."
               text-no-results="No se encontraron resultados"
               input-class="form-control form-control-small"
               match-class="highlight"
              >
              </div>
          </div>
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Población</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="poblacion" ng-model="$ctrl.poblacion"  disabled="disabled">
              
            </div>

       </div>
       <div class="form-group row">
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Provincia</label>
          <div class="col-sm-4">
              <input type="text" class="form-control" name="provincia" ng-model="$ctrl.provincia"  disabled="disabled">
          </div>
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Teléfono</label>
          <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.telefono.$invalid && !nuevo_cliente.telefono.$pristine }">
            <input type="number" name="telefono" class="form-control" id="telefono"  ng-model="$ctrl.telefono" placeholder="Fijo o movil" required="required"  ng-minlength="9" ng-maxlength="9">
            <p ng-show="nuevo_cliente.telefono.$error.minlength" class="help-block">Mínimo 9 caracteres</p>
            <p ng-show="nuevo_cliente.telefono.$error.maxlength" class="help-block">Máximo 9 caracteres</p>
          </div>
       </div>
       
 
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" ng-disabled="nuevo_cliente.$invalid" ng-click="$ctrl.nuevo_cliente($event)">{%$ctrl.btn%}</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
</form>