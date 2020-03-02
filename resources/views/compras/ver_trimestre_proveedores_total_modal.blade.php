
<div class="modal-header">
  <h4>Resumen por trimestre </h4>
</div>

 <div class="modal-body " id="modal-body" >
 	<p style="font-size: 17px;" ng-if="$ctrl.trimestre_total_presupuestos.length == 0">No se han encontrado registros</p>
      <div class="table-responsive">
		  <table class="table"  st-table="trimestre" st-safe-src="$ctrl.trimestre_total_presupuestos">
		        <thead>
		        	<tr>
		          	  <th colspan="6">Presupuestos emitidos</th>
		            </tr>    
		        </thead>
		          <tr>
		          	  <th style="text-align: right;" st-sort="trimestre">Trimestre</th>
		              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
		              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
		              <th style="text-align: right;" st-sort="totaliva">Total IVA </th>
		              <th style="text-align: right;" st-sort="importebruto">Importe bruto </th>
		              <th style="text-align: right;" st-sort="importeliquido">Total</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in trimestre">
		            	<td style="text-align: right;">{% row.trimestre %}</td>
		                <td style="text-align: right;">{% row.baseimponible | number:2 %}</td>
		                <td style="text-align: right;">{% row.importedescuentolineas | number:2 %}</td>
		                <td style="text-align: right;">{% row.totaliva | number:2 %}</td>
		                <td style="text-align: right;">{% row.importebruto | number:2 %}</td>
		                <td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
		            </tr>
		        </tbody>
		        <tfoot>
		         
		        </tfoot>
		  </table>
	</div>
</div> 
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
