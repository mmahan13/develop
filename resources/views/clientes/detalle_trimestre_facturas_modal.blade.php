
<div class="modal-header">
  <h4>Facturas trimestre {%$ctrl.trimestre %}</h4>
</div>

  <div class="modal-body " id="modal-body" >
 	
      <div class="table-responsive">
		  <table class="table"  st-table="trimestre" st-safe-src="$ctrl.facturas_por_trimestes">
		        <thead>
		          <tr>
		          	  <th style="text-align: right;" st-sort="numeroalbaran">Factura</th>
		          	  <th st-sort="fechaalbaran">Fecha</th>
		              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
		              <th style="text-align: right;" st-sort="totaliva">TotalIVA </th>
		              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
		              <th style="text-align: right;" st-sort="importebruto">Importe bruto </th>
		              <th style="text-align: right;" st-sort="importeliquido">Total Facturas</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in trimestre">
		            	<td style="text-align: right;">{% row.numeroalbaran %}</td>
		            	<td>{% row.fechaalbaran %}</td>
		                <td style="text-align: right;">{% row.baseimponible |number:2 %}</td>
		                <td style="text-align: right;">{% row.totaliva |number:2 %}</td>
		                <td style="text-align: right;">{% row.importedescuentolineas |number:2 %}</td>
		                <td style="text-align: right;">{% row.importebruto |number:2 %}</td>
		                <td style="text-align: right;">{% row.importeliquido |number:2 %}</td>
		            </tr>
		            <tr>
		            	<th colspan="7" style="text-align: right;">Total trimestre {%$ctrl.trimestre%}: {% $ctrl.total |number:2 %}</th>
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
 <button class="btn btn-default" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


