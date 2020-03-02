
<div class="modal-header">
  <h4>Presupuestos trimestre {%$ctrl.trimestre %}</h4>
 
</div>

  <div class="modal-body " id="modal-body" >
 	<p style="font-size: 17px;" ng-if="$ctrl.presupuestos_por_trimestes.length == 0">Aun no hay presupuestos en el trimestre {%$ctrl.trimestre %} </p>
      <div class="table-responsive" ng-if="$ctrl.presupuestos_por_trimestes.length > 0">
		  <table class="table"  st-table="trimestre" st-safe-src="$ctrl.presupuestos_por_trimestes">
		        <thead>
		          <tr>
		          	  <th style="text-align: right;" st-sort="numeropresupuesto">Presupuesto </th>
		              <th style="text-align: right;" st-sort="baseimponible">Base imponible </th>
		              <th style="text-align: right;" st-sort="totaliva">TotalIVA </th>
		              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
		              <th style="text-align: right;" st-sort="importebruto">Importe bruto </th>
		              <th style="text-align: right;" st-sort="importeliquido">Total presupuestos</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in trimestre">
		            	<td style="text-align: right;">{% row.numeropresupuesto %}</td>
		                <td style="text-align: right;">{% row.baseimponible %}</td>
		                <td style="text-align: right;">{% row.totaliva %}</td>
		                <td style="text-align: right;">{% row.importedescuentolineas %}</td>
		                <td style="text-align: right;">{% row.importebruto %}</td>
		                <td style="text-align: right;">{% row.importeliquido %}</td>
		            </tr>
		        </tbody>
		        <tfoot>
		         
		        </tfoot>
		  </table>
		     
		  </div>

</div> 
<div class="modal-footer">
  <!--<i style="font-size: 22px;" class="fa fa-spinner fa-pulse fa-3x fa-fw" ng-if="$ctrl.loading"></i>
  <span ng-if="$ctrl.loading" class="sr-only">Loading...</span>
 <button class="btn btn-default" ng-click="$ctrl.crearPdfProveedor($event)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>-->
 <button class="btn btn-btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


