<div class="table-responsive">
  <table class="table table-hover" st-table="pendientes" st-safe-src="$lCtrl.pendientes_facturacion">
      <thead>
        <tr>
          <th colspan="7">
            <input st-search="" placeholder="Buscar..." class="input-sm form-control" type="search">
          </th>
          <th ng-if="$lCtrl.pendientes_facturacion.length > 0"><button style="float: right;" type="button" class="btn btn-outline-success" ng-click="$lCtrl.facturarTodo($event, $lCtrl.fechai, $lCtrl.fechaf)">Faturar todo</button>
          </th>
        <tr>
          <th colspan="1" style="text-align: left;">
           <button style="float: left;" type="button" class="btn btn-light"><cambiar-fecha-component cambiar-fecha="$lCtrl.fechai" desde-donde="9" linea-contrato="$lCtrl.dato_generico" ></cambiar-fecha-component></button>
           <button style="float: right;" type="button" class="btn btn-light"><cambiar-fecha-component cambiar-fecha="$lCtrl.fechaf" desde-donde="10" linea-contrato="$lCtrl.dato_generico" ></cambiar-fecha-component></button>
          </th>
          <th colspan="6">
          </th>
        </tr>
      </thead>
  		
        <thead>
        	<tr>
            <th style="width: 19%;" st-sort="fecha">Fecha</th>
        	  <th style="text-align: right;" st-sort="numerocontrato">Contrato</th>
        	  <th st-sort="razonsocial">Cliente</th>
            <th style="text-align: right;" st-sort="importenetolineas">Importe bruto €</th>
            <th style="text-align: right;" st-sort="pordescuento">% descuento</th>
          	<th style="text-align: right;" st-sort="importedescuento">Importe descuento €</th>
          	<th style="text-align: right;" st-sort="baseimponible">Base Imponible €</th>
            <th style="text-align: right;"></th>
          </tr>    
        </thead>
        <tbody>
          <tr ng-repeat="row in pendientes" style="cursor: pointer;" ng-click="$lCtrl.detalleFacturar($event, row)">
            <td>{% row.fecha %} </td>
            <td style="text-align: right;">{% row.numerocontrato %}</td>
            <td>{% row.razonsocial %}</td>
            <td style="text-align: right;">{% row.importenetolineas | number:2 %}</td>
       			<td style="text-align: right;">{% row.pordescuento | number:0 %}</td>
       			<td style="text-align: right;">{% row.importedescuento | number:2 %}</td>
       			<td style="text-align: right;">{% row.baseimponible | number:2 %}</td>
            <td style="text-align: right;"><button type="button" class="btn btn-outline-success btn-sm" ng-click="$lCtrl.facturar($event, row)">Facturar</button></td>
          </tr>
          <tr ng-if="$lCtrl.total_a_facturar > 0">
            <th colspan="7" style="text-align: right;">Total EUR:  {% $lCtrl.total_a_facturar | number:2 %}</th>
            <th></th>
          </tr>
        </tbody>
  </table>
</div>		  
