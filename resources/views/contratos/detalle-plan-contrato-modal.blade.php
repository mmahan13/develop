
<div class="modal-header">
  <h4>Detalle</h4>
  <p style="font-size: 20px; float: right;">Facturado: {% $ctrl.facturado %}</p>
</div>
<div class="modal-body " id="modal-body" >
<div class="table-responsive">
	  <table class="table table-hover" st-table="detalle" st-safe-src="$ctrl.detalle_plan">
	  	<thead>
	        	<tr>
	        	  <th st-sort="fechainicio">F.inicio</th>
	        	  <th st-sort="fechafin">F.final</th>
	          	  <th st-sort="descripcionarticulo">Descipción</th>
	              <th style="text-align: right;" st-sort="unidades">Unidades</th>
	              <th style="text-align: right;" st-sort="importebruto">Precio</th>
	             	<th style="text-align: right;" st-sort="pordescuento">Dto %</th>
	              <th style="text-align: right;" st-sort="importedescuento">Dto €</th>
	              <th style="text-align: right;" st-sort="importeneto">Importe €</th>
				</tr>    
	        </thead>
	        <tbody>
	            <tr ng-repeat="row in detalle">
	            	<td>{% row.fechainicio %}</td>
	            	<td>{% row.fechafinal %}</td>
	            	<td>{% row.descripcionarticulo %}</td>
	            	<td ng-if="$ctrl.procesado == 1" style="text-align: right;">{% row.unidades | number:0%}</td>
	            	<td ng-if="$ctrl.procesado == 0" style="text-align: right;">
	            		<input style="text-align: right;" class="form-control" type="number" ng-model="row.unidades" min="1">
	            	</td>
	            	<td ng-if="$ctrl.procesado == 1" style="text-align: right;">{% row.importebruto | number:2%}</td>
	            	<td ng-if="$ctrl.procesado == 0" style="text-align: right;">
	            		<input style="text-align: right;" class="form-control" type="text" ng-model="row.importebruto" ng-value="row.importebruto" min="1" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" >
	            	</td>
	            	<td ng-if="$ctrl.procesado == 1" style="text-align: right;">{% row.pordescuento | number:0%}</td>
	            	<td ng-if="$ctrl.procesado == 0" style="text-align: right;">
	            		<input style="text-align: right;" class="form-control" type="number" ng-model="row.pordescuento" min="0">
	            	</td>
	            	<td style="text-align: right;">{% row.importedescuento | number:2%}</td>
	            	<td style="text-align: right;">{% row.importeneto | number:2%}</td>
	       		</tr>
	       	</tbody>
	  </table>
</div>	
</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.guardarCambios($event)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


