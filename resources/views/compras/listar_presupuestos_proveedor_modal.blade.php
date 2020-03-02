
<div class="modal-header">
  <h4><i class="fa fa-list-ul" aria-hidden="true"></i> Presupuestos {% $ctrl.razonsocial %}</h4>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>

<div class="modal-body " id="modal-body" style="padding: 40px;">
<p style="font-size: 17px;" ng-if="$ctrl.lista_presupuestos_proveedor.length == 0">Proveedor sin presupuestos</p>
<div class="table-responsive" ng-if="$ctrl.lista_presupuestos_proveedor.length > 0">
    <table class="table table-hover" style="cursor: pointer;" st-table="facturas" st-safe-src="$ctrl.lista_presupuestos_proveedor">
        <thead>
            
            <tr> 
                <th colspan="6">
                    <input st-search placeholder="Buscar presupuesto..." class="form-control form-control-sm" type="search"/>
                </th>
               <th></th>
            </tr>
            <tr>
                <th style="text-align: right; width: 8%;" st-sort="numeropresupuesto">Presupuesto</th>
                <th style="text-align: right;" st-sort="importebruto">Importe bruto</th>
                <th style="text-align: right;" st-sort="importedescuentolineas">% Descuento</th>
                <th style="text-align: right;" st-sort="baseimponible">Base imponible</th>
                <th style="text-align: right;" st-sort="totaliva">Total IVA</th>
                <th style="text-align: right;" st-sort="importeliquido">Total</th>
                <th st-sort="fechapresupuesto">Fecha</th>
                
        </thead>
        <tbody>
            <tr ng-repeat="row in facturas" ng-click="$ctrl.verPresupuesto($event, row)">
                <td style="text-align: right;">{% row.numeropresupuesto%}</td>
                <td style="text-align: right;">{% row.importebruto%}</td>
                <td style="text-align: right;">{% row.importedescuentolineas%}</td>
                <td style="text-align: right;">{% row.baseimponible%}</td>
                <td style="text-align: right;">{% row.totaliva%}</td>
                <td style="text-align: right;">{% row.importeliquido%}</td>
                <td>{% row.fechapresupuesto%}</td>
            </tr>
        </tbody>
        <tfoot>
         
        </tfoot>
    </table>
</div>

      
</div>      
        

</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


