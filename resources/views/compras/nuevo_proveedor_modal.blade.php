<div class="modal-header">
  <h4><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo proveedor</h4>
</div>
<form name="nuevo_cliente" method="post" class="form-horizontal" role="form" id="clienteForm">
<div class="modal-body " id="modal-body" style="padding: 25px;">

        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Logo</label>       
            <div class="col-sm-10">
                 <input type="file" class="form-control form-control-sm" ngf-select ng-model="file" name="file" ngf-max-size="600kb">
            </div>
        </div> 

        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="RazonSocial" class="form-control" id="RazonSocial"  ng-model="$ctrl.razonsocial" ng-minlength="2" ng-maxlength="40" placeholder="Nombre proveedor" required="required">
               <p ng-show="nuevo_cliente.RazonSocial.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                <p ng-show="nuevo_cliente.RazonSocial.$error.maxlength" class="help-block">Máximo 40 caracteres</p>
            </div>
        </div>

        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">CIF</label>
            <div class="col-sm-4" ng-class="{ 'has-error' : nuevo_cliente.CifDni.$invalid && !nuevo_cliente.CifDni.$pristine }">
              <input type="text" name="CifDni" class="form-control" id="CifDni"  ng-model="$ctrl.cifdni" required="required">
            </div>

             <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-4" ng-class="{'has-error' : nuevo_cliente.telefono.$invalid && !nuevo_cliente.telefono.$pristine }">
              <input type="number" name="telefono" class="form-control" id="telefono"  ng-model="$ctrl.telefono" placeholder="Fijo o movil" required="required"  ng-minlength="9" ng-maxlength="9">
              <p ng-show="nuevo_cliente.telefono.$error.minlength" class="help-block">Mínimo 9 caracteres</p>
              <p ng-show="nuevo_cliente.telefono.$error.maxlength" class="help-block">Máximo 9 caracteres</p>
            </div>
        </div>

        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">E-mail</label>
            <div class="col-sm-10" ng-class="{'has-error' : nuevo_cliente.email1.$invalid && !nuevo_cliente.email1.$pristine }">
              <input type="email" name="email1" class="form-control" id="email1"  ng-model="$ctrl.email1" placeholder="ejemplo@dominio.com" required="required">
            </div>
        </div>
       
       <div class="form-group row">
          <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Tipo Vía</label>
            <div class="col-sm-2">
               <select class="form-control" name="unidades_medida" ng-model="$ctrl.tipovia.sigla" ng-options="option.sigla for option in $ctrl.via track by option.id"></select> 
            
            </div>

            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Dirección</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="direccion" ng-minlength="2" ng-maxlength="60" ng-model="$ctrl.direccion"  required="required">
              <p ng-show="editar_cliente.direccion.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                <p ng-show="editar_cliente.direccion.$error.maxlength" class="help-block">Máximo 60 caracteres</p>
            </div>
       </div>

       <div class="form-group row">
        <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Nº</label>
          <div class="col-sm-2">
              <input type="number" class="form-control" name="numero1" ng-minlength="1" ng-maxlength="15" ng-model="$ctrl.numero1" placeholder="Nº" required="required">
              <p ng-show="editar_cliente.numero1.$error.minlength" class="help-block">Mínimo 1 caracteres</p>
                <p ng-show="editar_cliente.numero1.$error.maxlength" class="help-block">Máximo 10 caracteres</p>
          </div>

           <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Provincia</label>
            <div class="col-sm-6">
              <div angucomplete-alt
               id="provincia_autocomplete"
               placeholder="Buscar provincia"
               selected-object="$ctrl.currentProvincia"
               pause="100"
               selected-object="provincia_autocomplete"
               local-data="$ctrl.provincia"
               search-fields="provinciaid,provincia"
               title-field="provincia"
               minlength="1"
               text-searching="Buscando provincia..."
               text-no-results="No se encontraron resultados"
               input-class="form-control form-control-small"
               match-class="highlight"
              >
              </div>
          </div>
       </div>

      <div class="form-group row">
        <label ng-if="$ctrl.ver_input_poblacion" style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Población</label>
         <div class="col-sm-4" ng-if="$ctrl.ver_input_poblacion">
              <div angucomplete-alt
               id="poblacion_autocomplete"
               placeholder="Poblacion"
               selected-object="$ctrl.currentPoblacion"
               pause="100"
               selected-object="poblacion_autocomplete"
               local-data="$ctrl.poblacion"
               search-fields="poblacion"
               title-field="poblacion"
               minlength="1"
               text-searching="Buscando poblacion..."
               text-no-results="No se encontraron resultados"
               input-class="form-control form-control-small"
               match-class="highlight"
              >
              </div>
          </div>

          <label ng-if="$ctrl.ver_input_cp" style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">CP</label>
          <div class="col-sm-4" ng-if="$ctrl.ver_input_cp">
              <div angucomplete-alt
               id="codigopostal_autocomplete"
               placeholder=""
               selected-object="$ctrl.currentCodigoPostal"
               pause="100"
               selected-object="codigopostal_autocomplete"
               local-data="$ctrl.cp"
               search-fields="codigopostalid"
               title-field="codigopostalid"
               minlength="1"
               text-searching="Buscando código postal..."
               text-no-results="No se encontraron resultados"
               input-class="form-control form-control-small"
               match-class="highlight"
              >
              </div>
          </div>
      </div>

        <div class="form-group row">
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Comentario</label>
            <div class="col-sm-10">
               <textarea type="text" class="form-control" name="comentario" class="form-control" id="comentario"  ng-model="$ctrl.comentarios" ng-maxlength="80"></textarea> 
     
            </div>
        </div> 
    
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" ng-disabled="nuevo_cliente.$invalid" ng-click="$ctrl.nuevo_proveedor($event, file)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
</form>