<div class="table-responsive">
<table class="table table-hover" style="cursor: pointer;" st-table="datos" st-safe-src="$lCtrl.lista_lotes_facturas">
    <thead>
        
        <tr> 
            <th colspan="13">
                <input st-search placeholder="Buscar factura..." class="form-control form-control-sm" type="search"/>
            </th>
            <th>
              
            </th>
        </tr>
        <tr>
            <!--<th></th>-->
            <th st-sort="lote">Lote</th>
            <th st-sort="fechafactura">Fecha</th>
            <th style="text-align: right;" st-sort="numerofactura">Factura</th>
            <th st-sort="razonsocial">Cliente</th>
            <th st-sort="cifdni">CIF</th>
            <th st-sort="tipo_factura">Tipo factura</th>
            <th style="text-align: right;" st-sort="total_iva">Total IVA</th>
            <th style="text-align: right;" st-sort="importe_factura">Importe Factura</th>
            <th style="text-align: right;" st-sort="base_impobible_0">Base Imponible0 </th>
           
        </tr>
           
            
    </thead>
    <i ng-if="$lCtrl.loading" style="position: absolute;top: 40%;left: 35%;font-size: 70px;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span ng-if="$lCtrl.loading" class="sr-only">Loading...</span>
    <tbody>
        <tr ng-repeat="row in datos">
            <!--<td style="text-align: center" ng-click="$lCtrl.descargarPdf(row)"><i style="font-size: 18px;" class="fa fa-file-pdf-o" aria-hidden="true"></i></td>-->
            <td>{%row.lote%}</td>
            <td>{%row.fechafactura%}</td>
            <td style="text-align: right;">{%row.numerofactura%}</td>
            <td>{%row.razonsocial%}</td>
            <td >{%row.cifdni%}</td>
            <td>{%row.tipo_factura |number:0%}</td>
            <td style="text-align: right;">{%row.baseimponible |number:2%}</td>
            <td style="text-align: right;">{%row.total_iva|number:2%}</td>
            <td style="text-align: right;">{%row.importe_factura |number:2%}</td>
            <td style="text-align: right;">{%row.base_impobible_0 |number:2%}</td>
            
          
         </tr>
    </tbody>
 
</table>
</div>

