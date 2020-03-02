
<div class="modal-header">
  <h5>{% $ctrl.razonsocial %}</h5>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body " id="modal-body">
<p ng-if="$ctrl.lista_compra.length == 0">No se han encontrado registros</p>
<div class="table-responsive" ng-if="$ctrl.lista_compra.length > 0">
    <table class="table table-hover" style="cursor: pointer;" st-table="lista" st-safe-src="$ctrl.lista_compra">
        <thead>
            
            <tr> 
                <th colspan="7">
                    <input st-search placeholder="Buscar..." class="input-sm form-control" type="search"/>
                </th>
               <th></th>
            </tr>
            <tr>
                
                <th st-sort="descripcionarticulo">Descripción</th>
                <th st-sort="fechalinea">Fecha</th>
                <th style="text-align: right;" st-sort="unidades">Cantidad</th>
                <th style="text-align: right;" st-sort="importedescuento">Descuento</th>
                <th style="text-align: right;" st-sort="precio">Precio</th>
                <th style="text-align: right;" st-sort="cuotaiva">IVA</th>
                <th style="text-align: right;" st-sort="poriva">IVA%</th>
                <th style="text-align: right;" st-sort="importeliquido">Liquido</th>
            </tr> 
        </thead>
        <tbody>
            <tr ng-repeat="row in lista">
                <td>{% row.descripcionarticulo%}</td>
                <td>{% row.fechalinea%}</td>
                <td style="text-align: right;">{% row.unidades%}</td>
                <td style="text-align: right;">{% row.importedescuento | number:2%}</td>
                <td style="text-align: right;">{% row.precio | number:2%}</td>
                <td style="text-align: right;">{% row.cuotaiva%}</td>
                <td style="text-align: right;">{% row.poriva%}</td>
                <td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
               
            </tr>
             <tr>
                <th colspan="8" style="text-align: right;">Total: {% $ctrl.total | number:2%} €</th>
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


