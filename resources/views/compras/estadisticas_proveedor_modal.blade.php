<div class="modal-header">
  <h4><i class="fa fa-pie-chart" aria-hidden="true"></i> Datos {% $ctrl.razonsocial%}</h4>
</div>

<div class="modal-body " id="modal-body" >
<p style="font-size: 17px;" ng-if="$ctrl.trimestral.length == 0 && $ctrl.anual.length == 0">Debe realizar un presupuesto para ver los datos</p>
<div class="table-responsive" ng-if="$ctrl.trimestral.length > 0">
   <table class="table table-hover"  st-table="trimestre" st-safe-src="$ctrl.trimestral">
        <thead>
           <tr>
                <th colspan="6">TRIMESTAL</th>
            </tr>   
          <tr>
              <th style="text-align: right;" st-sort="trimestre">Trimestre</th>
              <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
              <th style="text-align: right;" st-sort="totaliva">Total IVA </th>
              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento</th>
              <th style="text-align: right;" st-sort="importebruto">Importe bruto</th>
              <th style="text-align: right;" st-sort="importeliquido">Total presupuestos</th>
              <th></th>
            </tr>    
        </thead>
        <tbody>
            <tr style="cursor: pointer;" ng-repeat="row in trimestre" ng-click="$ctrl.detalleTrimestre($event, row, $ctrl.codigoproveedor, $ctrl.codigoempresa)">
                <td style="text-align: right;">{% row.trimestre %}</td>
                <td style="text-align: right;">{% row.baseimponible %}</td>
                <td style="text-align: right;">{% row.totaliva %}</td>
                <td style="text-align: right;">{% row.importedescuentolineas %}</td>
                <td style="text-align: right;">{% row.importebruto %}</td>
                <td style="text-align: right;">{% row.importeliquido %}</td>
                <td ng-if="row.importeliquido > 3005.06">347 <i style="color:green" class="fa fa-circle" aria-hidden="true"></i></td>
            </tr>
        </tbody>
        <tfoot>
         
        </tfoot>
  </table>
  </div>
  <div class="table-responsive" ng-if="$ctrl.anual.length > 0">
  <table class="table"  st-table="anio" st-safe-src="$ctrl.anual">
        <thead>
           <tr>
                <th colspan="5">ANUAL</th>
            </tr>   
          <tr>
              <th style="text-align: right;" st-sort="baseimponible">Base imponible €</th>
              <th style="text-align: right;" st-sort="totaliva">Total IVA €</th>
              <th style="text-align: right;" st-sort="importedescuentolineas">Descuento €</th>
              <th style="text-align: right;" st-sort="importebruto">Importe bruto €</th>
              <th style="text-align: right;" st-sort="importeliquido">Total facturas €</th>
            </tr>    
        </thead>
        <tbody>
            <tr ng-repeat="row in anio">
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
  <button class="btn btn-btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>

