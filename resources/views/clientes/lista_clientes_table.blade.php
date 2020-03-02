<button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.nuevoCliente($event)">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo cliente
            </button>
            <br><br>
<div id="grid1" ui-grid="$lCtrl.tableOpts"  ui-grid-auto-resize  ui-grid-resize-columns  class="grid"></div>

 {{--
    <p ng-if="$lCtrl.lista_clientes.length == 0">No se han encontrado registros</p>
 <div class="table-responsive" ng-if="$lCtrl.lista_clientes.length > 0">
  
   <table class="table table-hover"  st-table="lista" st-safe-src="$lCtrl.lista_clientes">
        <thead>
            <tr> 
                <th colspan="4">
                    <input st-search placeholder="Buscar cliente" class="form-control form-control-sm" type="search"/>
                </th>
                <th style="width: 10%;" colspan="2">
                    <button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.nuevoCliente($event)">
                         <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo cliente
                    </button>
                </th>
            </tr>
            <tr>
                <th style="width:15%" st-sort="rasonsocial">Cliente</th>
                <th style="width:1%" st-sort="cifdni">CIF</th>
                <th style="width:1%" st-sort="email1">E-Mail</th>
                <th st-sort="nombre1">Contacto</th>
                <th st-sort="fechaalta">Fecha alta</th>
                <th style="text-align: center;">Facturas</th>
                <!--<th style="width: 6%">Artículos</th>
                 <th style="width: 6%">Datos</th>-->
            </tr>    
                
        </thead>
        <tbody>
            <tr ng-repeat="row in lista" style="cursor: pointer;">
                <td ng-click="$lCtrl.fichaCliente($event,row)">{%row.razonsocial%}</td>
                <td ng-click="$lCtrl.fichaCliente($event,row)">{%row.cifdni%}</td>
                <td ng-click="$lCtrl.fichaCliente($event,row)">{%row.email1%}</td>
                <td ng-click="$lCtrl.fichaCliente($event,row)">{%row.nombre1%}</td>
                <td ng-click="$lCtrl.fichaCliente($event,row)">{%row.fechaalta%}</td>
                <td style="text-align: center; cursor: pointer;" ng-click="$lCtrl.listadoDeFacturas($event,row.idcliente)"><i class="fa fa-list-ol" aria-hidden="true"></i></td>
                <!--<td style="text-align: center;" ng-click="$lCtrl.compra($event,row)"><i class="fa fa-cubes" aria-hidden="true"></i></td>
                <td style="text-align: center;" ng-click="$lCtrl.estadisticas($event,row)"><i class="fa fa-pie-chart" aria-hidden="true"></i></td>-->
            </tr>
             
        </tbody>
       
    </table>
</div>    
--}}
