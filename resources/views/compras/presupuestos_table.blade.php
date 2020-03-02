<p ng-if="$lCtrl.lista_presupuestos.length == 0" style="font-size: 20px;">No hay facturas para mostrar</p>
<div class="table-responsive" ng-if="$lCtrl.lista_presupuestos.length > 0">
<table class="table table-hover" style="cursor: pointer;" st-table="lineaspresupuesto" st-safe-src="$lCtrl.lista_presupuestos">
    <thead>
        
        <tr> 
            <th colspan="11">
                <input st-search placeholder="Buscar..." class="form-control form-control-sm" type="search"/>
            </th>
             <!--<th>
                <button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.verTrimestreTotalPresupuestos($event)">
                    Trimestres
                </button>
            </th>-->
        </tr>
        <tr>
            <th></th>
            <th st-sort="fechapresupuesto">Fecha</th>
            <th style=" text-align: right;" st-sort="serie">Serie</th>
            <th style=" text-align: right;" st-sort="numeropresupuesto">Factura</th>
            <th st-sort="razonsocial">Proveedor</th>
            <th st-sort="cifdni">CIF</th>
            <th style="text-align: right;" st-sort="importebruto">Bruto €</th>
            <th style="text-align: right;" st-sort="importedescuento">Dto €</th>
            <th style="text-align: right;" st-sort="sumabases">Base €</th>
            <th style="text-align: right;" st-sort="cuotaiva">IVA €</th>
            <th style="text-align: right;" st-sort="importerecargo">Recargo €</th>
            <th style="text-align: right;" st-sort="sindescuentoretencion">SubTotal €</th>
            <th style="text-align: right;" st-sort="importeretencion">Retención €</th>
            <th style="text-align: right;" st-sort="importeliquido">Total €</th>
            
    </thead>
    <i ng-if="$lCtrl.loading" style="position: absolute;top: 40%;left: 35%;font-size: 70px;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span ng-if="$lCtrl.loading" class="sr-only">Loading...</span>

    <tbody>
        <tr ng-repeat="row in lineaspresupuesto">
            <td  style="text-align: center" ng-click="$lCtrl.descargarPresupuestoPdf(row)"><i style="font-size:21px;" class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)">{%row.fechafactura%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.serie%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.numerofactura%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)">{%row.razonsocial%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)">{%row.cifdni%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.importebruto |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.importedescuento |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.sumabases |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.totaliva |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.importerecargo |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.sindescuentoretencion |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.importeretencion |number:2%}</td>
            <td ng-click="$lCtrl.verPresupuesto($event, row)" style="text-align: right;">{%row.importeliquido |number:2%}</td>
           
        </tr>
    </tbody>
    <tfoot>
     
    </tfoot>
</table>
</div>