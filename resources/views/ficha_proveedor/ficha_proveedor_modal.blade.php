<div class="modal-header">
  <h5>FICHA PROVEEDOR</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>
<form name="editar_cliente" method="post" class="form-horizontal" role="form" id="clienteForm">
<div class="modal-body " id="modal-body" style="padding: 40px;">

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-3 col-form-label">Razon Social</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="RazonSocial" class="form-control" id="RazonSocial"  ng-model="$ctrl.razonsocial" ng-minlength="2" ng-maxlength="20" placeholder="Nombre cliente o empresa" required="required">
                     <p ng-show="editar_cliente.RazonSocial.$error.minlength" class="help-block">Mínimo 2 caracteres</p>
                      <p ng-show="editar_cliente.RazonSocial.$error.maxlength" class="help-block">Máximo 30 caracteres</p>
                  </div>
                 
            </div>

            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-3 col-form-label">CIF</label>
                  <div class="col-sm-9" ng-class="{ 'has-error' : editar_cliente.CifDni.$invalid && !editar_cliente.CifDni.$pristine }">
                    <input type="text" name="CifDni" class="form-control" id="CifDni"  ng-model="$ctrl.cifdni" required="required">
                  </div>
            </div>
              
            <div class="form-group row">
                  <label style="text-align:right" for="inputPassword" class="col-sm-3 col-form-label">E-mail</label>
                  <div class="col-sm-9" ng-class="{'has-error' : editar_cliente.email1.$invalid && !editar_cliente.email1.$pristine }">
                    <input type="email" name="email1" class="form-control" id="email1"  ng-model="$ctrl.email1" placeholder="ejemplo@dominio.com" required="required">
                  </div>
            </div>  
            
        </div>
        <div class="col-sm-4">
           <div class="col-sm-12">  
              <img style="float: right;margin-right: 50px;width: 50%;" ng-if="$ctrl.logoempresa != null" ng-src="{% $ctrl.logoempresa %}" class="img-responsive">
              <img style="float: right;margin-right: 50px;width: 50%;" ng-if="$ctrl.logoempresa == null"  ng-src="img/sinImagen.jpg" class="img-responsive" >    
              
            </div> 
        </div>
    </div>
     
        
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-12 col-form-label">Domicilios</label>
          <div class="table-responsive">
            <table class="table table-hover" style="cursor: pointer;" st-table="lista" st-safe-src="$ctrl.domicilios">
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
            <label style="text-align:right" for="inputPassword" class="col-sm-2 col-form-label">Comentario</label>
            <div class="col-sm-10">
               <textarea type="text" class="form-control" name="comentario" class="form-control" id="comentario"  ng-model="$ctrl.comentarios" ng-maxlength="80"></textarea> 
     
            </div>
        </div> 

         <div class="table-responsive">
        <table class="table table-hover">
        <tbody>
        <tr>
          <td style="cursor: pointer; text-align: center" ng-click="$ctrl.listadoDePresupuestos($event)">Presupuestos</td>
          <td style="cursor: pointer; text-align: center" ng-click="$ctrl.articulosPresupuestos($event)">Artículos</td>
          
        </tr>
        </tbody>
      </table>           
      </div>

</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" ng-disabled="editar_cliente.$invalid" ng-click="$ctrl.guardar_cambios($event)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
</form>

