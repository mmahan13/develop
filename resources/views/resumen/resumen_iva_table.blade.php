 <div class="table-responsive">
		  <table class="table"  st-table="trimestre" st-safe-src="$lCtrl.emitidas">
		        <thead>
		        	<tr>
		          	  <th colspan="6">Facturas emitidas</th>
		            </tr>    
		        </thead>
		          <tr>
		          	  <th style="width: 10px" st-sort="trimestre">Trimestre</th>
		              <th style="text-align: right;" st-sort="baseimponible">Base imponible €</th>
		          	  <th style="text-align: right;" st-sort="totaliva">Total IVA  €</th>
		              <th style="text-align: right;" st-sort="importeliquido">Importe liquido €</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in trimestre">
		            	<td style="width: 10px">{% row.trimestre %}</td>
		                <td style="text-align: right;">{% row.baseimponible | number:2 %}</td>
		      			<td style="text-align: right;">{% row.totaliva | number:2 %}</td>
		       			<td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
		            </tr>
		        </tbody>
		        <tfoot>
		         
		        </tfoot>
		  </table>
		   <table class="table"  st-table="recibidas" st-safe-src="$lCtrl.recibidas">
		        <thead>
		        	<tr>
		          	  <th colspan="6">Facturas recibidas</th>
		            </tr>    
		        </thead>
		          <tr>
		          	 <th style="width: 10px" st-sort="trimestre">Trimestre</th>
		             <th style="text-align: right;" st-sort="baseimponible">Base imponible €</th>
		             <th style="text-align: right;" st-sort="totaliva">Total IVA  €</th>
		             <th style="text-align: right;" st-sort="importeliquido">Importe liquido €</th>
		            </tr>    
		        </thead>
		        <tbody>
		            <tr ng-repeat="row in recibidas">
		            	<td style="width: 10px">{% row.trimestre %}</td>
		                <td style="text-align: right;">{% row.baseimponible | number:2 %}</td>
		              	<td style="text-align: right;">{% row.totaliva | number:2 %}</td>
		                <td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
		            </tr>
		        </tbody>
		        <tfoot>
		         
		        </tfoot>
		  </table>
	</div>