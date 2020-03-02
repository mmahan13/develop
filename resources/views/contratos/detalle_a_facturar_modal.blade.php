<div class="modal-header">
  <h4>Detalle </h4>
</div>
<div class="modal-body " id="modal-body" >
<div class="table-responsive">
  <table class="table" st-table="datos" st-safe-src="$ctrl.detalle_a_facturar">
  	<thead>
  		<tr>
    	  <th st-sort="descripcionarticulo">Descipción</th>
          <th style="text-align: right;" st-sort="unidades">Unidades</th>
          <th style="text-align: right;" st-sort="importebruto">Precio</th>
      	  <th style="text-align: right;" st-sort="importedescuento">Dto €</th>
          <th style="text-align: right;" st-sort="importeneto">Importe €</th>
		</tr>    
    </thead>
    <tbody>
            <tr ng-repeat="row in datos">
            	<td>{% row.descripcionarticulo %}</td>
            	<td style="text-align: right;">{% row.unidades | number:0%}</td>
            	<td style="text-align: right;">{% row.importebruto | number:2%}</td>
            	<td style="text-align: right;">{% row.importedescuento | number:2%}</td>
            	<td style="text-align: right;">{% row.importeneto | number:2%}</td>
       		</tr>
       		<tr ng-if="$ctrl.pordescuento > 0">
       			<th colspan="4" style="text-align: right;">Importe bruto: </th>
       			<td colspan="1" style="text-align: right;">{% $ctrl.importenetolineas %} €</td>
       		</tr>
       		<tr ng-if="$ctrl.pordescuento > 0">
       			<th colspan="4" style="text-align: right;border-top: 0px solid #ffffff;">% Descuento: </th>
       			<td colspan="5" style="text-align: right;border-top: 0px solid #ffffff;">{% $ctrl.pordescuento %} %</td>
       		</tr>
       		<tr ng-if="$ctrl.pordescuento > 0">
       			<th colspan="4" style="text-align: right;border-top: 0px solid #ffffff;">Impt descuento: </th>
       			<td colspan="5" style="text-align: right;border-top: 0px solid #ffffff;">{% $ctrl.importedescuento %} €</td>
       		</tr>
       		<tr ng-if="$ctrl.pordescuento > 0">
       			<th colspan="4" style="text-align: right;border-top: 0px solid #ffffff;">Base imponible: </th>
       			<th colspan="5" style="text-align: right;border-top: 0px solid #ffffff;">{% $ctrl.baseimponible %} €</th>
       		</tr>
       	</tbody>
  </table>
</div>	
</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


