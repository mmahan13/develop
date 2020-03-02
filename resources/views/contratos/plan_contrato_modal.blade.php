
<div class="modal-header">
  <h4>Planes contrato {%$ctrl.numerocontrato%}</h4>
</div>
<div class="modal-body " id="modal-body" >
<div class="table-responsive">
	  <table class="table table-hover" st-table="plan" st-safe-src="$ctrl.lineas_plan">
	  	<thead>
	        	<tr>
	          	  <th st-sort="fecha">Fecha inicio</th>
	              <th st-sort="fechafin">Fecha fin</th>
	              <th style="text-align: right;" st-sort="importenetolineas">Importe bruto €</th>
	              <th style="text-align: right;" st-sort="importedescuento">Importe descuento €</th>
	              <th style="text-align: right;" st-sort="pordescuento">% descuento</th>
	              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
	          	  <th st-sort="procesado">Facturado</th>
	              <th style="text-align: right;" st-sort="numeroalbaran">Factura</th>
	            </tr>    
	        </thead>
	        <tbody>
	            <tr style="cursor: pointer;" ng-click="$ctrl.detallePlan($event, row)" ng-repeat="row in plan">
	            	<td>{% row.fecha %}</td>
	                <td>{% row.fechafin%}</td>
	                <td style="text-align: right;">{% row.importenetolineas | number:2 %}</td>
	                <td style="text-align: right;">{% row.importedescuento | number:2 %}</td>
	                <td style="text-align: right;">{% row.pordescuento | number:0 %}</td>
	                <td style="text-align: right;">{% row.baseimponible | number:2 %}</td>
	                <td ng-if="row.procesado == 1">Si</td>
	       			<td ng-if="row.procesado == 0">No</td>
	       			<td style="text-align: right;" ng-if="row.numeroalbaran != 0">{%row.numeroalbaran%}</td>
	       			<td style="text-align: right;" ng-if="row.numeroalbaran == 0"> - </td>
	       		</tr>
	       	</tbody>
	  </table>
</div>	
</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


