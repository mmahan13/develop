
<div class="modal-header">
  <h4>FACTURAS {% $ctrl.razonsocial %}</h4>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>

<div class="modal-body " id="modal-body" style="padding: 40px;">

<div class="table-responsive">
    <table class="table table-hover" st-table="facturas" st-safe-src="$ctrl.lista_facturas_cliente">
        <thead>
            
            <tr> 
                <th colspan="2">
                    <input st-search placeholder="Buscar..." class="form-control form-control-sm" type="search"/>
                </th>
               <th></th>
            </tr>
            <tr>
                <th st-sort="fechafactura">Fecha</th>
                <th style="text-align: right; width: 8%;" st-sort="numerofactura">Factura</th>
                <th style="text-align: right;" st-sort="importeliquido">Total</th>
            </tr>   
                
        </thead>
        <tbody>
            <tr ng-repeat="row in facturas" ng-click="$ctrl.verFactura($event, row)" style="cursor: pointer;">
                <td>{% row.fechafactura%}</td>
                <td style="text-align: right;">{% row.numerofactura%}</td>
                <td style="text-align: right;">{% row.importeliquido |number:2%}</td>
            </tr>
            <tr>
                <th colspan="7" style="text-align: right;">Total: {%$ctrl.total | number:2%}</th>
            </tr>
        </tbody>
       
    </table>
</div>

      
</div>      
        

</div>
<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


