<div class="modal-header">
  <h4>Contrato</h4>
</div>
<div class="modal-body " id="modal-body" >

			<div class="col-sm-12">
              <div angucomplete-alt
               id="cliente_autocomplete"
               placeholder="Busque un cliente"
               selected-object="$ctrl.currentCliente"
               pause="100"
               selected-object="provincia_autocomplete"
               local-data="$ctrl.lista_clientes"
               search-fields="cifdni,razonsocial"
               title-field="razonsocial"
               minlength="1"
               text-searching="Buscando cliente..."
               text-no-results="No se encontraron resultados"
               input-class="form-control form-control-small"
               match-class="highlight"
              >
              </div>
        </div>
        <div style="padding: 15px" ng-if="$ctrl.ver_cif" class="table-responsive">
        	<table class="table">
        		<thead>
        			<tr>
        				<th>Cod.</th>
        				<th>Cliente</th>
        				<th>CIF</th>
        				<th>Teléfono</th>
        				<th>Domicilio</th>
        				
					</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>{%$ctrl.codigocliente%}</td>
        				<td>{%$ctrl.razonsocial%}</td>
        				<td>{%$ctrl.cifdni%}</td>
        				<td>{%$ctrl.telefono%}</td>
        				<td>{%$ctrl.domicilio%}</td>
        			
        			</tr>
        		</tbody>
        	</table>
        </div>
       
   
<div class="modal-footer">
 <button class="btn btn-default" ng-if="$ctrl.ver_cif" ng-click="$ctrl.crearContrato($event)">Nuevo contrato</button>
 <button class="btn btn-default" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
