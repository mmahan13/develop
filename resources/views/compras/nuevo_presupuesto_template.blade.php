<div class="table-responsive" >
    <table class="table"  st-table="lista_cabecera" st-safe-src="$lCtrl.hoja_factura">
            <thead>
                <tr>
                   
                    <th>Tipo Factura</th>
                    <th style="width: 25%">Proveedor</th>
                    <th>Fecha</th>
                    <th ng-show="$lCtrl.nogasto">Serie</th>
                    <th ng-show="$lCtrl.nogasto">Factura</th>
                    <th style="width: 25%">Descripción</th>
                    <th ng-if="$lCtrl.nogasto == false">{% $lCtrl.datos.ivas[3].tipoiva %}</th>
                    <th ng-if="$lCtrl.nogasto == false  && $lCtrl.hoja_factura[0].baseivaexento > 0"></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in lista_cabecera">
                    <!--<td style="width: 1px;">
                        <i style="font-size: 12px" class="fa fa-times" aria-hidden="true" ng-click="$lCtrl.removeRowFactura(row)"></i>
                    </td>-->
                    <td>
                     <select class="form-control" name="tipo" ng-change="$lCtrl.cambiarTipoFactura($lCtrl.estado.tipo.id)" ng-options="option.tipo for option in $lCtrl.datos.tipoFactura track by option.id"  ng-model="$lCtrl.estado.tipo"></select>
                    </td>
                    <td style="width:20%;">
                      <div ng-init="row.currentProveedor = $lCtrl.currentProveedor(row)"></div>
                      <div angucomplete-alt
                         id="proveedor_autocomplete"
                         placeholder="Buscar proveedor..."
                         selected-object="row.currentProveedor"
                         pause="100"
                         selected-object="proveedor_autocomplete"
                         local-data="$lCtrl.lista_proveedores"
                         search-fields="cifdni,razonsocial"
                         title-field="razonsocial"
                         minlength="3"
                         text-searching="Buscando proveedor..."
                         text-no-results="No se encontraron resultados"
                         input-class="form-control form-control-small"
                         match-class="highlight">
                        </div>
                    </td>

                    <td><input type="date" class="form-control" name="fecha"  ng-model="row.fecha"></td>
                    <td ng-show="$lCtrl.nogasto"><input type="text" class="form-control" name="serie"  ng-model="row.serie"></td>
                    <td ng-show="$lCtrl.nogasto"><input type="text" class="form-control" name="numero_factura"  ng-model="row.numero_factura"></td>
                    <td><input type="text" class="form-control" name="descripcion_factura"  ng-model="row.descripcion_factura"></td>
                    <td ng-if="$lCtrl.nogasto == false"><input type="number" class="form-control" name="baseivaexento"  ng-model="row.baseivaexento" min="0"></td>
                    <td ng-if="$lCtrl.nogasto == false && $lCtrl.hoja_factura[0].baseivaexento > 0 " >
                      <button type="button" class="btn btn-success" ng-click="$lCtrl.aniadirFactura($event, $lCtrl.estado.tipo.id)">Añadir</button>
                    </td>
                  </tr> 
            </tbody>
    </table>
    <table class="table"  st-table="lista_cabecera" st-safe-src="$lCtrl.hoja_factura">
            <thead>
                <tr>
                    <th ng-show="$lCtrl.nogasto">Desc %</th>
                    <th ng-show="$lCtrl.nogasto">{% $lCtrl.datos.ivas[0].tipoiva %}</th>
                    <th ng-show="$lCtrl.nogasto">{% $lCtrl.datos.ivas[1].tipoiva %}</th>
                    <th ng-show="$lCtrl.nogasto">{% $lCtrl.datos.ivas[2].tipoiva %}</th>
                    <th ng-if="$lCtrl.nogasto">{% $lCtrl.datos.ivas[3].tipoiva %}</th>
                    <th ng-show="$lCtrl.nogasto">Retención</th>
                    <!--<th ng-show="$lCtrl.nogasto">Recargo</th>-->
                
                </tr>
            </thead>
            <tbody>
              <tr ng-repeat="row in lista_cabecera">
                  <td ng-show="$lCtrl.nogasto"><input type="number" class="form-control" name="pordescuento" ng-model="row.pordescuento"  min="0"></td>
                  <td ng-show="$lCtrl.nogasto"><input type="number" class="form-control" name="baseiva" ng-model="row.baseiva" min="0"></td>
                  <td ng-show="$lCtrl.nogasto"><input type="number" class="form-control" name="baseiva2"  ng-model="row.baseiva2" min="0"></td>
                  <td ng-show="$lCtrl.nogasto"><input type="number" class="form-control" name="baseiva3"  ng-model="row.baseiva3" min="0"></td>
                  <td ng-if="$lCtrl.nogasto"><input type="number" class="form-control" name="baseivaexento"  ng-model="row.baseivaexento" min="0"></td>
                  <td ng-show="$lCtrl.nogasto"><input type="number" class="form-control" name="porretencion"  ng-model="$lCtrl.porretencion" min="0"></td>
                  <!--<td ng-show="$lCtrl.nogasto" style="text-align: center">
                    <i class="fa fa-2x fa-toggle-off" style="cursor: pointer;margin: 5px;color:{%$lCtrl.c%}" ng-click="$lCtrl.recargoEquivalencia($lCtrl.recargoequivalencia)" ng-model="$lCtrl.recargoequivalencia.recargoequivalencia" ng-class="{'fa-toggle-on': $lCtrl.recargoequivalencia == 1, 'fa-toggle-off': $lCtrl.recargoequivalencia == 0}" is-disabled="false"></i>
                  </td>-->
              </tr> 
            </tbody>
    </table>

   


</div>

<div class="table-responsive" ng-show="$lCtrl.nogasto">
<table class="table" st-table="lista_articulos" st-safe-src="$lCtrl.hoja">
    <thead>
        <tr>
            <!--ng-click="$lCtrl.addList($event)"-->
           <!-- <th style="width: 1%;"><i style="cursor: pointer;" class="fa fa-list-ol" aria-hidden="true"></i></th> -->
            <th style="width: 10%;">Artículo</th>
            <th style="width: 10%;">Descripción</th>
            <th style="width: 1%;">Cantidad</th>
            <th style="width: 2%;">Precio €</th>
            <th style="width: 1%;">Desc %</th>
            <th style="text-align: right; width: 1%;">IVA %</th>
            <th style="text-align: right; width: 1%;">Importe €</th>
            
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="row in lista_articulos">
           <!-- <td ng-if="$lCtrl.hoja.length > 1">
                <i style="font-size: 12px" class="fa fa-times" aria-hidden="true" ng-click="$lCtrl.removeRow(row)"></i>
            </td>
             <td ng-if="$lCtrl.hoja.length <= 1"></td>-->
            <td>
                <div ng-init="row.currentArticulo = $lCtrl.currentArticulo(row)"></div>
                 <div angucomplete-alt
                       id="articulo_autocomplete"
                       placeholder="Buscar artículo"
                       selected-object="row.currentArticulo"
                       pause="150"
                       selected-object="articulo_autocomplete"
                       local-data="$lCtrl.articulos"
                       search-fields="codigoarticulo,descripcionarticulo"
                       title-field="descripcionarticulo"
                       minlength="3"
                       text-searching="Buscando artículo..."
                       text-no-results="No se encontraron resultados"
                       input-class="form-control form-control-small"
                       match-class="highlight"
                      >
              </div>
            <!--<p style="margin: 5px; cursor: pointer; font-size: 12px"  ng-click="$lCtrl.addcomentario($event,row)">{%row.descripcionlinea%}</p>-->
             
            </td>
            <td><input type="text" class="form-control" name="descripcionlinea"  ng-model="row.descripcionlinea" maxlength="150"></td>
            <td><input type="number" class="form-control" name="cantidad"  ng-model="row.cantidad" min="0" max="999" style="width:70px"></td>
            <td><input type="number" class="form-control" name="preciocompra" ng-model="row.preciocompra" min="1" style="width: 113px;"></td>
            <td><input type="number" class="form-control" name="descuento"  ng-model="row.descuento" min="0" max="100"></td>
            <td style="text-align: right;">{% row.porcentaje %}</td>
            <td style="text-align: right;">{%row.liquido | number: 2%}</td>
            
        </tr>

    </tbody>
    <tfoot>

    </tfoot>
</table>

</div>

<div class="row" style="margin-bottom: 30px;" ng-show="$lCtrl.nogasto">
    <div class="col-sm-6">
        <table class="table" st-table="ivas" st-safe-src="$lCtrl.totales_por_iva">
            <thead>
                <tr> 
                    <th>T.IVA</th>
                    <th style="text-align: right;">Base Imponible</th>
                    <th style="text-align: right;">%IVA</th>
                    <th style="text-align: right;">Total I.V.A</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in ivas" ng-if="row.total_importe > 0">
                    <td>{% row.tipoiva %}</td>
                    <td style="text-align: right;">{% row.total_importe | number: 2 %}</td>
                    <td style="text-align: right;">{% row.porcentaje |number: 0%}</td>
                    <td style="text-align: right;">{% row.total_iva | number:2 %}</td>
                </tr>
               

            </tbody>
        </table>
    </div>
 
    <div class="col-sm-6" style="margin-top: 10px;">
          <div class="row" style="margin-top: 0px;margin-right: -5px;">
            <div class="col">
                <p><strong>Importe Bruto</strong></p>
                <p><strong>Base imponible</strong></p>
                <p><strong>Total I.V.A</strong></p>
                <p style="margin-top: 10px"><strong>Total factura EUR</strong></p>
            </div>
            <div class="col">
                <P style="text-align: right;">{% $lCtrl.base_imponible | number: 2 %}</P>
                <P style="text-align: right;">{% $lCtrl.base_imponible | number: 2 %}</P>
                <P style="text-align: right;">{% $lCtrl.totalIVA | number: 2 %}</P>
                <P style="text-align: right; margin-top: 10px"><strong>{% $lCtrl.total_factura | number: 2 %}</strong></P>
            </div>
          </div>
    </div>
  </div>
{{--<div class="row" style="margin-bottom: 10px;"  ng-if="$lCtrl.total_factura > 0" ng-show="$lCtrl.nogasto">
  <!--<div class="col-6">
      <div class="form-group">
        <label for="comment">Observaciones</label>
      <textarea class="form-control" rows="2" id="observaciones" ng-model="$lCtrl.observaciones" maxlength="150"></textarea>
  </div>
  </div>-->
    <div class="col-12">
        <button style="float:right;" type="button" class="btn btn-success" ng-click="$lCtrl.generarNuevaFactura($event)">Generar factura</button>
    </div>
</div> --}}   

<div class="row"  ng-show="$lCtrl.nogasto" class="row" style="margin-bottom: 10px;" ng-if="$lCtrl.hoja_factura[0].baseiva > 0 || $lCtrl.hoja_factura[0].baseiva2 > 0 || $lCtrl.hoja_factura[0].baseiva3 > 0 || $lCtrl.hoja_factura[0].baseivaexento > 0 || $lCtrl.total_factura > 0" >
  <div class="col-12">
        <button style="float: right;" type="button" class="btn btn-success" ng-click="$lCtrl.aniadirFactura($event,$lCtrl.estado.tipo.id)">Generar factura</button>
    </div>
</div>




   


