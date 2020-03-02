<div class="table-responsive">
        <table class="table" st-table="datos_oferta"  st-safe-src="$lCtrl.numero_oferta">
            <thead>
                <tr> 
                    <th style="width:35%;">Cliente</th>
                    <th style="width:10%;">Fecha oferta</th>
                    <th style="width:9%;">Serie</th>
                    <th style="width:7%;text-align:center">Nº Oferta</th>
                    <th style="width:8%">Dto %</th>
                    <th style="width:8%">Retención %</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in datos_oferta">
                    <td> 
                      <div angucomplete-alt
                         id="cliente_autocomplete"
                         placeholder="Buscar cliente"
                         selected-object="$lCtrl.currentCliente"
                         pause="100"
                         selected-object="provincia_autocomplete"
                         local-data="$lCtrl.lista_clientes"
                         search-fields="codigocliente,razonsocial"
                         title-field="razonsocial"
                         minlength="3"
                         text-searching="Buscando cliente..."
                         text-no-results="No se encontraron resultados"
                         input-class="form-control form-control-small"
                         match-class="highlight"
                        >
                      </div>
                    </td>
                    <td><input type="date" class="form-control" name="fecha"  ng-model="$lCtrl.fecha"></td>
                    <td>
                      <input type="text" min="0"class="form-control" name="serieoferta"  ng-model="$lCtrl.serieoferta">
                      <p ng-show="$lCtrl.formserieoferta">Máximo 20 caracteres</p>
                    </td>
                    <td style="text-align: center">{% row.numerooferta%} </td>
                    <td>
                      <input style="text-align: right;" type="number" min="0" class="form-control" name="pordescuento"  ng-model="$lCtrl.pordescuento">
                       <p ng-show="$lCtrl.formpordescuento">Máximo 100%</p>
                    </td>
                    <td>
                      <input style="text-align: right;" type="number" class="form-control" name="porretencion"  ng-model="$lCtrl.porretencion" min="0">
                      <p ng-show="$lCtrl.formporretencion">Máximo 100%</p>
                    </td>
                   
                </tr>
            </tbody>
        </table>
</div>

<div class="table-responsive" ng-if="$lCtrl.idcliente" >
<table class="table" st-table="lista_articulos" st-safe-src="$lCtrl.hoja">
    <thead>
        <tr>
            <!--ng-click="$lCtrl.addList($event)"-->
            <th style="width: 1%;"><i class="fa fa-list-ol" aria-hidden="true"></i></th> 
            <th style="width: 10%;">Artículo</th>
            <th style="width: 10%;">Descripción</th>
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
                       id="articulo_autocomplete"
                       placeholder="Buscar artículo"
                       selected-object="row.currentArticulo"
                       pause="100"
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
            </td>
            <td><input type="text" class="form-control" name="descripcionlinea"  ng-model="row.descripcionlinea" maxlength="150"></td>
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
                <p  ng-if="$lCtrl.importeretencion > 0"><strong>Retención</strong> <span style="float: right;">{% $lCtrl.importeretencion | number: 2 %}</span></p>
                <p style="margin-top: 10px"><strong>Total factura</strong> <span style="float: right;">{% $lCtrl.total_factura | number: 2 %}</span></p>
            </div>
            
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
        <button style="float: right;margin-top: 10%;" type="button" class="btn btn-success" ng-click="$lCtrl.generarNuevaOferta($event)">Generar Oferta</button>
    </div>
</div>    
{{--
<script type="text/ng-template" id="calendario-modal.html">
        @include('modals.calendario_modal')
</script>
<script type="text/ng-template" id="crear-contrato-modal.html">
        @include('factura.crear_contrato_modal')
</script>--}}
