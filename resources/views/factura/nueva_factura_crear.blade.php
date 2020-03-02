<div class="table-responsive">
        <table class="table" st-table="datos_factura"  st-safe-src="$lCtrl.datos_nueva_factura">
            <thead>
                <tr> 
                    <th style="width: 30%;">Cliente
                    <div angucomplete-alt
                         id="cliente_autocomplete"
                         placeholder="Buscar cliente"
                         selected-object="$lCtrl.currentCliente"
                         pause="100"
                         selected-object="provincia_autocomplete"
                         local-data="$lCtrl.lista_clientes"
                         search-fields="id,nombre"
                         title-field="nombre"
                         minlength="3"
                         text-searching="Buscando cliente..."
                         text-no-results="No se encontraron resultados"
                         input-class="form-control form-control-small"
                         match-class="highlight"
                        >
                      </div></th>
                    <th>Fecha 
                      <input type="date" class="form-control" name="fecha"  ng-model="$lCtrl.fecha"></th>
                    <th>Serie
                    <input type="text" min="0" class="form-control" name="seriefactura"  ng-model="$lCtrl.seriefactura" disabled>
                    </th>
                    <th>Factura <input type="text" min="0" class="form-control" name="numerofactura"  ng-model="$lCtrl.numerofactura" disabled></th>
                    <th>Dto% Total Factura
                    <input style="text-align: right;" type="number" min="0" class="form-control" name="pordescuento"  ng-model="$lCtrl.pordescuento">
                       <p ng-show="$lCtrl.formpordescuento">Máximo 100%</p>
                    </th>
                </tr>
            </thead>
           
        </table>
</div>

<div class="table-responsive" >
<table class="table" st-table="lista_articulos" st-safe-src="$lCtrl.hoja">
    <thead>
        <tr>
           
            <th style="width: 1%;"><i class="fa fa-list-ol" aria-hidden="true"></i></th> 
            <th style="width: 10%;">Artículo</th>
            <th style="width: 3%;">Cantidad</th>
            <th style="width: 3%;">Precio €</th>
            <th style="width: 3%;">Dto %</th>
            <th style="text-align: right; width: 3%;">IVA %</th>
            <th style="text-align: right; width: 3%;">Importe €</th>
            
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="row in lista_articulos">
            <td ng-if="$lCtrl.hoja.length > 1">
                <i style="font-size: 12px" class="fa fa-times" aria-hidden="true" ng-click="$lCtrl.removeRow(row)"></i>
            </td>
             <td ng-if="$lCtrl.hoja.length <= 1"></td>
            <td>
                <div ng-init="row.currentArticulo = $lCtrl.currentArticulo(row)"></div>
                 <div angucomplete-alt
                       id="productos_autocomplete"
                       placeholder="Buscar artículo"
                       selected-object="row.currentArticulo"
                       pause="100"
                       selected-object="productos_autocomplete"
                       local-data="$lCtrl.productos"
                       search-fields="ref,producto"
                       title-field="producto"
                       minlength="3"
                       text-searching="Buscando artículo..."
                       text-no-results="No se encontraron resultados"
                       input-class="form-control form-control-small"
                       match-class="highlight"
                      >
              </div>
            </td>
            <!--<td><input type="text" class="form-control" name="descripcionlinea"  ng-model="row.descripcionlinea" maxlength="150"></td>-->
            <td><input type="number" min="0"  class="form-control" name="cantidad"  ng-model="row.cantidad"></td>
            <td><input type="number" min="0" class="form-control" name="precioventa"  ng-model="row.precioventa"></td>
            <td>
              <input type="number" min="0"  class="form-control" name="descuento"  ng-model="row.descuento">
               <p ng-show="$lCtrl.formdescuento">Máximo 100%</p>
            </td>
            <td style="text-align: right;">{% row.porcentaje %}</td>
            <td style="text-align: right;">{%row.liquido | number: 2%}</td>
            
        </tr>

    </tbody>
    <tfoot>

    </tfoot>
</table>

</div>

<div class="row">
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
            <div class="col-sm-12">
                <p><strong>Importe bruto</strong> <span style="float: right;">{% $lCtrl.importenetolienas | number: 2 %}</span></p>
                <p ng-if="$lCtrl.descuentototalfactura > 0"><strong>Dto</strong> <span style="float: right;">{% $lCtrl.descuentototalfactura | number:2 %}</span></p>
                <p><strong>Base imponible</strong> <span style="float: right;">{% $lCtrl.base_imponible | number: 2 %}</span></p>
                <p><strong>Total I.V.A</strong> <span style="float: right;">{% $lCtrl.totalIVA | number: 2 %}</span></p>
                <p ng-if="$lCtrl.importesubtotal >0"><strong>Subtotal</strong> <span style="float: right;">{% $lCtrl.importesubtotal | number: 2 %}</span></p>
                <!--<p  ng-if="$lCtrl.importeretencion > 0"><strong>Retención</strong> <span style="float: right;">{% $lCtrl.importeretencion | number: 2 %}</span></p>-->
                <p style="margin-top: 10px"><strong>Total factura</strong> <span style="float: right;">{% $lCtrl.total_factura | number: 2 %}</span></p>
            </div>
            <!--<div class="col">
                <P style="text-align: right;">{% $lCtrl.importenetolienas | number: 2 %}</P>
                <P style="text-align: right;">{% $lCtrl.base_imponible | number: 2 %}</P>
                <P style="text-align: right;">{% $lCtrl.totalIVA | number: 2 %}</P>
                <P style="text-align: right; margin-right: -55px;"><input style="height: 30px;width: 22%;margin-left: 290px;margin-top: -7px;text-align: right;" type="number" min="0" class="form-control form-control-sm" name="descuento_total_factura"  ng-model="$lCtrl.pordescuento" ></p>
                <P style="text-align: right;">{% $lCtrl.descuentototalfactura %}</p>
                <P style="text-align: right; margin-top: 10px"><strong>{% $lCtrl.total_factura | number: 2 %}</strong></P>
            </div>-->
          </div>
    </div>
  </div>
 

<div class="row" style="margin-bottom: 10px;"  ng-if="$lCtrl.total_factura > 0">
  <div class="col-6">
      <div class="form-group">
        <label for="comment">Observaciones</label>
      <textarea class="form-control" rows="2" id="observaciones" ng-model="$lCtrl.observaciones" maxlength="150"></textarea>
</div>
  </div>
    <div class="col-6">
        <button style="float: right;margin-top: 10%;" type="button" class="btn btn-success" ng-click="$lCtrl.generarNuevaFactura($event)">Generar factura</button>
    </div>
</div>    

<script type="text/ng-template" id="calendario-modal.html">
        @include('modals.calendario_modal')
</script>
<script type="text/ng-template" id="crear-contrato-modal.html">
        @include('factura.crear_contrato_modal')
</script>
