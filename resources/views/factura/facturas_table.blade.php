
<div id="grid1" ui-grid="$lCtrl.tableOpts"  ui-grid-auto-resize  ui-grid-resize-columns  class="grid"></div>
{{--
<div class="table-responsive">
<table class="table table-hover" style="cursor: pointer;" st-table="facturas" st-safe-src="$lCtrl.lista_facturas">
    <thead>
        
        <tr> 
            <th colspan="13">
                <input st-search placeholder="Buscar factura..." class="form-control form-control-sm" type="search"/>
            </th>
            <th>
                <!--<button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.verTrimestreTotal($event)">
                    Trimestres
                </button>-->
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="width: 90px;" st-sort="fechaalbaran">Fecha</th>
            <th style="text-align: right;" st-sort="numeroalbaran">Factura</th>
            <th st-sort="razonsocial">Cliente</th>
            <th st-sort="cifdni">CIF</th>
            <th style="text-align: right;" st-sort="importebruto">Importe bruto €</th>
            <th style="text-align: right;" st-sort="pordescuento">Dto %</th>
            <th style="text-align: right;" st-sort="importedescuento">Dto €</th>
            <th style="text-align: right;" st-sort="baseimponible">Base imponible €</th>
            <th style="text-align: right;" st-sort="totaliva">IVA €</th>
            <th style="text-align: right;" st-sort="totaliva">Recargo €</th>
            <th style="text-align: right;" st-sort="subtotal">SubTotal €</th>
            <th style="text-align: right;" st-sort="importeretencion">Retencion €</th>
            <th style="text-align: right;" st-sort="importeliquido">Total factura €</th>
        </tr>
           
            
    </thead>
    <i ng-if="$lCtrl.loading" style="position: absolute;top: 40%;left: 35%;font-size: 70px;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span ng-if="$lCtrl.loading" class="sr-only">Loading...</span>
    <tbody>
        <tr ng-repeat="row in facturas">
            <td style="text-align: center" ng-click="$lCtrl.descargarPdf(row)"><i style="font-size: 18px;" class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
            <td  ng-click="$lCtrl.verFactura($event, row)">{%row.fechafactura%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.numerofactura%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)">{%row.razonsocial%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)">{%row.cifdni%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.importenetolineas |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.pordescuento |number:0%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.importedescuento |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.baseimponible |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.cuotaiva |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.importerecargo |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.subtotal |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.importeretencion |number:2%}</td>
            <td  ng-click="$lCtrl.verFactura($event, row)" style="text-align: right;">{%row.importeliquido |number:2%}</td>
         </tr>
    </tbody>
 
</table>
</div>
--}}
