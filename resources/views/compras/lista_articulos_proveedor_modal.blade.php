<div class="modal-header">
  <h4>Artículos</h4>
</div>

<div class="modal-body " id="modal-body" style="padding: 25px;">
<p ng-if="$ctrl.lista_articulos.length == 0">No se han encontrado registros</p>
<div class="table-responsive" ng-if="$ctrl.lista_articulos.length > 0">
    <table class="table" st-table="lista" st-safe-src="$ctrl.lista_articulos">
        <thead>
            
            <tr> 
                <th colspan="7">
                    <input st-search placeholder="Buscar..." class="form-control form-control-sm" type="search"/>
                </th>
               <th></th>
            </tr>
            <tr>
                <th st-sort="fechalinea">Fecha</th>
                <th st-sort="descripcionarticulo">Descripción</th>
                <th style="text-align: right;" st-sort="unidades">Cantidad</th>
                <th style="text-align: right;" st-sort="importedescuento">Descuento</th>
                <th style="text-align: right;" st-sort="precio">Precio€</th>
                <th style="text-align: right;" st-sort="poriva">IVA%</th>
                <th style="text-align: right;" st-sort="importebruto">Importe€</th>
        </thead>
        <tbody>
            <tr ng-repeat="row in lista">
                <td>{% row.fechalinea%}</td>
                <td>{% row.descripcionarticulo%}</td>
                <td style="text-align: right;">{% row.unidades%}</td>
                <td style="text-align: right;">{% row.importedescuento | number:2%}</td>
                <td style="text-align: right;">{% row.precio | number:2%}</td>
                <td style="text-align: right;">{% row.poriva%}</td>
                <td style="text-align: right;">{% row.importebruto | number:2%}</td>
        
            </tr>
            <tr>
            	<td colspan="5"></td>
            	<td colspan="2" style="text-align: right;">Total: {% $ctrl.total | number:2%}</td>
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
