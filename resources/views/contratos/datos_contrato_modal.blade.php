
<div class="modal-header">
  <h4>Datos contrato</h4> <!--<button type="button" class="btn btn-light" ng-click="$ctrl.newFactura($event)">Generar factura</button>-->
</div>

<div class="modal-body " id="modal-body" >
	<form>
	  <div class="form-group">
	  	<div class="row">
		<div class="col-2">
		  	<label for="numcontrato">Núm. Contrato</label>
	 		<input type="text" class="form-control" name="numerocontrato" class="form-control" id="numerocontrato"  ng-model="$ctrl.numerocontrato" disabled>
	 	</div>

	 	<div class="col-3">
		  	<label for="iniciocontrato">Fecha activación <span ng-if="$ctrl.facturado == 0" style="color:blue;margin:initial;margin-left:60px;font-size: 11px;margin-top: 5px;"><cambiar-fecha-component cambiar-fecha="$ctrl.fechaactivacion" desde-donde="2" linea-contrato="$ctrl.cabecera_contrato[0]"></cambiar-fecha-component> <i class="fa fa-pencil" aria-hidden="true"></i></span></label>
	    	<input type="text" class="form-control" name="fechaactivacion" class="form-control" id="fechaactivacion"  ng-model="$ctrl.fechaactivacion" disabled>
		</div>
		
		 <div class="col-3">
		  	<label for="iniciocontrato">Fecha inicio <span style="color:blue;margin:initial;margin-left:89px;font-size: 11px;margin-top: 5px;"><cambiar-fecha-component cambiar-fecha="$ctrl.fechacontrato" desde-donde="5" linea-contrato="$ctrl.cabecera_contrato[0]"></cambiar-fecha-component> <i class="fa fa-pencil" aria-hidden="true"></i></span></label>
	    	<input type="text" class="form-control" name="fechacontrato" class="form-control" id="fechacontrato"  ng-model="$ctrl.fechacontrato" disabled>
		  </div>
		  <div class="col-3">
		  	<label for="finalcontrato">Fecha final <span style="color:blue;margin:initial;margin-left:89px;font-size: 11px;margin-top: 5px;"><cambiar-fecha-component cambiar-fecha="$ctrl.fechafinal" desde-donde="8" linea-contrato="$ctrl.cabecera_contrato[0]"></cambiar-fecha-component> <i class="fa fa-pencil" aria-hidden="true"></i></span></label>
	    	<input type="text" class="form-control" name="fechafinal" class="form-control" id="fechafinal"  ng-model="$ctrl.fechafinal" disabled>
		  </div>
		 <div class="col-1">
		  	<label for="Renueva">Renueva</label><br>
		  	<i style="margin-top: 2px; margin-left: 5px;color: green; cursor: pointer;" class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="$ctrl.estado" output-prop-name="renueva" ng-click="$ctrl.renuevaContrato($event, $ctrl.idcontrato)" ng-class="{'fa-toggle-on': $ctrl.renueva == 1, 'fa-toggle-off': $ctrl.renueva == 0}"></i>
	    </div>
		</div>
	  </div>
	  <div class="form-group">
	  	<div class="row">
	  	<div class="col-5">
		  	<label for="razonsocial">Razón social</label>
	    	<input type="text" class="form-control" name="razonsocial" class="form-control" id="razonsocial"  ng-model="$ctrl.razonsocial" disabled>	
		  </div>
		 <div class="col-3">
		  	<label for="cif">CIF</label>
	    	<input type="text" class="form-control" name="cifdni" class="form-control" id="cifdni"  ng-model="$ctrl.cifdni" disabled>
		  </div>
		  <div class="col-3">
		  	<label for="telefono">Teléfono</label>
	    	<input type="text" class="form-control" name="telefono" class="form-control" id="telefono"  ng-model="$ctrl.telefono" disabled>
		  </div>
		  
		<div class="col-1">
		  	<label for="estado">Activo</label><br>
		  	<i style="margin-top: 2px; margin-left: 5px;color: green; cursor: pointer;" class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="$ctrl.estado" output-prop-name="estado" ng-click="$ctrl.activarContrato($event, $ctrl.idcontrato)" ng-class="{'fa-toggle-on': $ctrl.estado == 1, 'fa-toggle-off': $ctrl.estado == 0}"></i>
		
		 </div>
		</div>
	  </div>
	</form>

	<div class="table-responsive">
		  <table class="table table-hover" st-table="contrato" st-safe-src="$ctrl.cabecera_contrato">
		  	<thead>
	        	<tr>
	        		<th colspan="7">Total contrato</th>
	        		<th colspan="2" style="text-align: right;">
	        			<button type="button" ng-click="$ctrl.planContrato($event,$ctrl.idcontrato, $ctrl.numerocontrato)" class="btn btn-secondary" ng-if="$ctrl.lineas_contrato != undefined && $ctrl.lineas_contrato.length > 0">Ver planes</button>
	        		</th>
	        	</tr>
		    </thead>    	
		        <thead>
		        	<tr>
		        	  <th style="text-align: right;">Histórico €</th>
		        	  <th style="text-align: right;">Anual €</th>
		        	  <th style="text-align: right;">impt bruto €</th>
		        	  <th style="text-align: right;">Dto %</th>
		          	  <th style="text-align: right;">Dto €</th>
		              <th style="text-align: right;">Base imponible €</th>
		              <th style="text-align: right;">Total IVA €</th>
		          	  <th style="text-align: right;">Total contrato €</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in contrato" style="cursor: pointer;" title="Editar Dto %" ng-click="$ctrl.editarCabeceraContrato($event,row)">
		            	<td style="text-align: right;">{% row.importehistorico | number:2 %}</td>
		            	<td style="text-align: right;">{% row.importeanual | number:2 %}</td>
		            	<td style="text-align: right;">{% row.importenetolineas | number:2 %}</td>
		            	<td style="text-align: right;">{% row.pordescuento | number:0%}</td>
		            	<td style="text-align: right;">{% row.importedescuento | number:2%}</td>
		                <td style="text-align: right;">{% row.importeneto | number:2 %}</td>
		                <td style="text-align: right;">{% row.totaliva | number:2 %}</td>
		               	<td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
		       		</tr>
		       	</tbody>
		        <tfoot>
		         
		        </tfoot>
		  </table>
	</div>

	<div class="table-responsive">
	  <table class="table table-hover" st-table="lineas" st-safe-src="$ctrl.lineas_contrato">
	  	<thead>
        	<tr>
        		<th colspan="9">Lineas contrato</th>
        		<th colspan="2" style="text-align: right;">
        			<button type="button" ng-click="$ctrl.addLinea($event,$ctrl.idcontrato, $ctrl.numerocontrato)" class="btn btn-secondary">Añadir linea</button>
        		</th>
        	</tr>
	    </thead>    	
        <thead>
        	<tr>
        	  <th>Activo</th>
        	  <th st-sort="factivacion">F.activación</th>
        	  <th st-sort="fechainicio">F.inicio</th>
        	  <th st-sort="fechafinal">F.final</th>
          	  <th st-sort="descripcionarticulo">Descripción</th>
			  <th style="text-align: right;" st-sort="unidades">Uds</th>
              <th style="text-align: right;" st-sort="precio">Precio €</th>
          	  <th style="text-align: right;" st-sort="pordescuento">Dto %</th>
          	  <th style="text-align: right;" st-sort="descuento">Dto €</th>
          	  <th style="text-align: right;" st-sort="poriva">IVA %</th>
              <th style="text-align: right;" st-sort="neto">Importe €</th>
            </tr>    
        </thead>
        <tbody>
            <tr ng-repeat="row in lineas" style="cursor: pointer;">
            	<td class="text-center" style="font-size: 14px; color:green" ng-disabled="true">
                	<i class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="row" output-prop-name="bajalinea" ng-click="$ctrl.activarDesactivarArticulo($event, row, $ctrl.cabecera_contrato[0].importeliquido)" ng-class="{'fa-toggle-on': row.bajalinea == 0, 'fa-toggle-off': row.bajalinea == 1} "></i>
                </td>
                <td title="Editar fecha activación" ng-if="row.numeroalbaran == 0 && row.idalbaran == null"><cambiar-fecha-component cambiar-fecha="row.factivacion" linea-contrato="row" desde-donde="11" linea-contrato="row"></cambiar-fecha-component></td>
            	<td ng-if="$ctrl.facturado == 1">{%row.factivacion%}</td>
            	<td title="Editar fecha inicio" ng-if="row.numeroalbaran == 0 && row.idalbaran == null"><cambiar-fecha-component cambiar-fecha="row.fechainicio" linea-contrato="row" desde-donde="6"></cambiar-fecha-component></td>
            	<td ng-if="row.numeroalbaran != 0 && row.idalbaran != null">{% row.fechainicio %}</td>
            	<td title="Editar fecha final" ><cambiar-fecha-component cambiar-fecha="row.fechafinal" linea-contrato="row" desde-donde="7"></cambiar-fecha-component></td>
            	<td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)">{% row.descripcionarticulo %}</td>
                <td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)"style="text-align:right;">{% row.unidades | number:0%}</td>
                <td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)" style="text-align:right;">{% row.precio | number:2%}</td>
                <td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)" style="text-align:right;">{% row.pordescuento | number:0%}</td>
               	<td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)" style="text-align:right;">{% row.descuento | number:2%}</td>
               	<td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)" style="text-align:right;">{% row.poriva | number:0%}</td>
       			<td title="Editar uds, precio o dto %" ng-click="$ctrl.editarLineaContrato($event,row)" style="text-align:right;">{% row.neto | number:2%}</td>
      		</tr>
       	</tbody>
	  </table>
	</div>	
</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


