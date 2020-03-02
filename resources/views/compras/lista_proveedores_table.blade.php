
    <div class="table-responsive">
    <table class="table table-hover" style="cursor: pointer;" st-table="listado" st-safe-src="$lCtrl.listado_proveedores">
        <thead>
            <tr> 
                <th colspan="2">
                    <input st-search placeholder="Buscar Proveedor" class="form-control form-control-sm" type="search"/>
                </th>
                <th style="width: 10%;" colspan="2">
                    <button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.nuevoProveedor($event)">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo proveedor
                    </button>
                </th>
            </tr>
            <tr>
                <th st-sort="rasonsocial">Proveedor</th>
                <th st-sort="cifdni">CIF</th>
                <th st-sort="email1">E-Mail</th>
                <th st-sort="fechaalta">Alta</th>
               <!-- <th style="width: 6%">Presupuestos</th>
                <th style="width: 6%">Artículos</th>-->
            </tr>    
                
        </thead>
        <tbody>
            <tr ng-repeat="row in listado">
                <td  ng-click="$lCtrl.fichaProveedor($event,row)">{%row.razonsocial%}</td>
                <td  ng-click="$lCtrl.fichaProveedor($event,row)">{%row.cifdni%}</td>
                <td  ng-click="$lCtrl.fichaProveedor($event,row)">{%row.email1%}</td>
                <td  ng-click="$lCtrl.fichaProveedor($event,row)">{%row.fechaalta%}</td>
                <!--<td style="text-align: center;" ng-click="$lCtrl.listadoDePresupuestos($event, row)"><i class="fa fa-list-ol" aria-hidden="true"></i></td>
                <td style="text-align: center;" ng-click="$lCtrl.articulosPresupuestos($event,row)"><i class="fa fa-cubes" aria-hidden="true"></i></td>-->
            </tr>
        </tbody>
        <tfoot>
         
        </tfoot>
    </table>
    </div>
 
<!--<div class="col-2">
    <div class="table-responsive" style="cursor: pointer;width: 65%;">
       <table class="table table-hover"  st-table="lista" st-safe-src="$lCtrl.listado_proveedores">
        <thead>
            <th>
                <button type="button" disabled class="btn btn-light">Historial</button>
            </th>
            <tr>
                <th>Datos</th>
            </tr>   
        </thead>
        <tbody>
            <tr ng-repeat="row in lista" ng-click="$lCtrl.estadisticas_proveedor($event,row)">
                <td><i class="fa fa-pie-chart" aria-hidden="true"></i></td>
            </tr>
        </tbody>
        <tfoot>
         
        </tfoot>
    </table>
  </div>
</div>-->
</div>