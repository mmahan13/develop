<div class="modal-header">
  <h4>{% $ctrl.razonsocial%}</h4>
</div>

<div class="modal-body " id="modal-body" >

<div class="table-responsive">
   <table class="table table-hover"  st-table="trimestre" st-safe-src="$ctrl.trimestral">
        <thead>
          <tr>
                <th colspan="7">Facturas emitidas </th>
            </tr>
           <tr>
                <th colspan="7">TRIMESTAL </th>
            </tr>   
          <tr>
              <th style="text-align: right;" st-sort="trimestre">Trimestre</th>
              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
              <th style="text-align: right;" st-sort="totaliva">TotalIVA</th>
              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
              <th style="text-align: right;" st-sort="importebruto">Importe bruto</th>
              <th style="text-align: right;" st-sort="importeliquido">Total</th>
            </tr>    
        </thead>
        <tbody>
            <tr style="cursor: pointer;" ng-repeat="row in trimestre" ng-click="$ctrl.detalleTrimestreFacturas($event, row, $ctrl.codigocliente, $ctrl.codigoempresa)">
                <td style="text-align: right;">{% row.trimestre %}</td>
                <td style="text-align: right;">{% row.baseimponible |number:2 %}</td>
                <td style="text-align: right;">{% row.totaliva |number:2 %}</td>
                <td style="text-align: right;">{% row.importedescuentolineas |number:2 %}</td>
                <td style="text-align: right;">{% row.importebruto |number:2 %}</td>
                <td style="text-align: right;">{% row.importeliquido |number:2 %}</td>
            </tr>
        </tbody>
        <tfoot>
         
        </tfoot>
  </table>

  <table class="table"  st-table="anio" st-safe-src="$ctrl.anual">
        <thead>
           <tr>
                <th colspan="7">ANUAL</th>
            </tr>   
          <tr>
              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
              <th style="text-align: right;" st-sort="totaliva">Total IVA</th>
              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
              <th style="text-align: right;" st-sort="importebruto">Importe bruto</th>
              <th style="text-align: right;" st-sort="importeliquido">Total</th>
            </tr>    
        </thead>
        <tbody>
            <tr ng-repeat="row in anio">
                <td style="text-align: right;">{% row.baseimponible |number:2 %}</td>
                <td style="text-align: right;">{% row.totaliva |number:2 %}</td>
                <td style="text-align: right;">{% row.importedescuentolineas |number:2 %}</td>
                <td style="text-align: right;">{% row.importebruto |number:2 %}</td>
                <td style="text-align: right;">{% row.importeliquido |number:2 %}</td>
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

