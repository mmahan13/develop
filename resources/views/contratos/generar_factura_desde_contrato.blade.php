<div class="modal-header">
  <h4>Generar factura</h4> 
</div>
<div class="modal-body " id="modal-body" >
  <div class="row">
    <div class="col-sm-6">
       <div class="table-responsive">
        <table class="table" st-table="datoscliente"  st-safe-src="$ctrl.cabecera_factura">
            <thead>
                <tr> 
                    <th>Cliente</th>
                    <th>CIF</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in datoscliente">
                     <td>{% row.razonsocial %} </td>
                     <td>{% row.cifdni %} </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="table-responsive">
        <table class="table" st-table="datos_factura"  st-safe-src="$ctrl.datos_nueva_factura">
            <thead>
                <tr> 
                    <th>Fecha</th>
                    <th style="text-align: right;">Ejercicio</th>
                    <th style="text-align: right;">Factura</th>
                    <!--<th style="text-align: right;">Crear contrato</th>-->
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="row in datos_factura">
                     <td><cambiar-fecha-component cambiar-fecha="row.fecha" desde-donde="0"></cambiar-fecha-component></td>
                     <td style="text-align: right;">{% row.ejercicio%} </td>
                     <td style="text-align: right;">{% row.numerofactura%} </td>

                     <td style="text-align: right;">
                    <!--  <i class="fa fa-2x fa-toggle-off" style="cursor: pointer" ng-click="$ctrl.crearContrato($event, row.fecha)" ng-model="$ctrl.periodica" ng-class="{'fa-toggle-on': $ctrl.hacerperiodica == 1, 'fa-toggle-off': $ctrl.hacerperiodica == 0}" is-disabled="false"></i>-->
                      </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
  </div>

<div class="table-responsive" >
<table class="table" st-table="lista_articulos" st-safe-src="$ctrl.hoja">
    <thead>
        <tr>
            <!--ng-click="$ctrl.addList($event)"-->
            <th style="width: 1%;"><i class="fa fa-list-ol" aria-hidden="true"></i></th> 
            <th style="width: 20%;">Descripción</th>
            <th style="width: 1%"></th>
            <th style="width: 3%;">Unidades</th>
            <th style="text-align: right; width: 3%;">Precio €</th>
            <th style="width: 3%;">Descuento %</th>
            <th style="text-align: right; width: 3%;">IVA %</th>
            <th style="text-align: right; width: 3%;">Importe €</th>
            
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="row in lista_articulos">
            <td ng-if="$ctrl.hoja.length > 1">
                <i style="font-size: 12px" class="fa fa-times" aria-hidden="true" ng-click="$ctrl.removeRow(row)"></i>
            </td>
            <td ng-if="$ctrl.hoja.length <= 1"></td>
            <td ng-if="row.descripcionarticulo != '' && row.cantidad != 0">{%row.descripcionarticulo%}</td>
            <td ng-if="row.descripcionarticulo == '' && row.cantidad == 0">
                <div ng-init="row.currentArticulo = $ctrl.currentArticulo(row)"></div>
                 <div angucomplete-alt
                       id="articulo_autocomplete"
                       placeholder="Buscar artículo"
                       selected-object="row.currentArticulo"
                       pause="100"
                       selected-object="articulo_autocomplete"
                       local-data="$ctrl.articulos"
                       search-fields="codigoarticulo,descripcionarticulo"
                       title-field="descripcionarticulo"
                       minlength="1"
                       text-searching="Buscando artículo..."
                       text-no-results="No se encontraron resultados"
                       input-class="form-control form-control-small"
                       match-class="highlight"
                      >
              </div>
              <p style="margin: 5px">{%row.comentario%}</p>
            </td>
            <td style="cursor: pointer;"><i ng-click="$ctrl.addcomentario($event,row)" class="fa fa-commenting-o" aria-hidden="true"></i></td>
            <td><input type="number" min="0"  class="form-control" name="cantidad"  ng-model="row.cantidad"></td>
            <td style="text-align: right;">{% row.precioventa | number:2 %}</td>
            <td><input type="number" min="0"  class="form-control" name="descuento"  ng-model="row.descuento"></td>
            <td style="text-align: right;">{% row.porcentaje %}</td>
            <td style="text-align: right;">{%row.liquido | number: 2%}</td>
            
        </tr>

    </tbody>
    <tfoot>

    </tfoot>
</table>

</div>

<div class="row" style="margin-bottom: 30px;">
    <div class="col-sm-6">
        <table class="table" st-table="ivas" st-safe-src="$ctrl.totales_por_iva">
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
                <p><strong>Importe bruto</strong></p>
                <p><strong>Base imponible</strong></p>
                <p><strong>Total I.V.A</strong></p>
                <!--<p><strong>%Descuento</strong></p>-->
                <p style="margin-top: 10px"><strong>Total factura</strong></p>
            </div>
            <div class="col">
                <P style="text-align: right;">{% $ctrl.bruto | number: 2 %}</P>
                <P style="text-align: right;">{% $ctrl.base_imponible | number: 2 %}</P>
                <P style="text-align: right;">{% $ctrl.totalIVA | number: 2 %}</P>
                <!--<P style="text-align: right;"><input style="height: 30px;width: 20%;margin-left: 290px;margin-top: -15px;text-align: right;" type="number" min="0" class="form-control" name="descuento_total_factura"  ng-model="$ctrl.descuento_total_factura" ></p>-->
                <P style="text-align: right; margin-top: 10px"><strong>{% $ctrl.total_factura | number: 2 %}</strong></P>
            </div>
          </div>
    </div>
  </div>
 

<div class="row" style="margin-bottom: 10px;"  ng-if="$ctrl.total_factura > 0">
  <div class="col-6">
      <div class="form-group">
        <label for="comment">Observaciones</label>
      <textarea class="form-control" rows="2" id="observaciones" ng-model="$ctrl.observaciones" maxlength="150"></textarea>
</div>
  </div>
    <div class="col-6">
        <button style="float: right;margin-top: 10%;" type="button" class="btn btn-success" ng-click="$ctrl.generarNuevaFactura($event)">Generar factura</button>
    </div>
</div>  
</div>
<div class="modal-footer">
 <button class="btn btn-default" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>  

<script type="text/ng-template" id="calendario-modal.html">
        @include('modals.calendario_modal')
</script>
<script type="text/ng-template" id="crear-contrato-modal.html">
        @include('factura.crear_contrato_modal')
</script>
