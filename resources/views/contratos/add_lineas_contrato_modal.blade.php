
<div class="modal-header">
  <h4>Nueva linea</h4>
</div>

<div class="modal-body " id="modal-body" >
	<div class="table-responsive" >
<table class="table" st-table="lista_articulos" st-safe-src="$ctrl.hoja">
    <thead>
        <tr>
            <!--ng-click="$ctrl.addList($event)"-->
            <th style="width: 1%;"><i style="cursor: pointer;" class="fa fa-list-ol" aria-hidden="true"></i></th> 
            <th style="width: 20%;">Descripción</th>
            <!--<th style="width: 1%"></th>-->
            <th style="width: 1%;">Unidades</th>
            <th style="text-align: right; width: 3%;">Precio €</th>
            <th style="width: 6%;">Dto %</th>
            <th style="text-align: right; width: 3%;">IVA %</th>
            <th style="text-align: right; width: 3%;">Importe €</th>
            <th style="width: 3%;">Activo</th>
            
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="row in lista_articulos">
            <td ng-if="$ctrl.hoja.length > 1">
                <i style="font-size: 12px" class="fa fa-times" aria-hidden="true" ng-click="$ctrl.removeRow(row)"></i>
            </td>
             <td ng-if="$ctrl.hoja.length <= 1"></td>
            <td>
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
              <!--<p style="margin: 5px">{%row.comentario%}</p>-->
            </td>
            <!--<td style="cursor: pointer;"><i ng-click="$ctrl.addcomentario($event,row)" class="fa fa-commenting-o" aria-hidden="true"></i></td>-->
            <td><input type="number"  min="0"  class="form-control" name="unidades"  ng-model="row.unidades"></td>
            <td style="text-align: right;">{% row.precioventa | number:2 %}</td>
            <td><input type="number"  min="0"  class="form-control" name="descuento"  ng-model="row.descuento"></td>
            <td style="text-align: right;">{% row.porcentaje %}</td>
            <td style="text-align: right;">{%row.liquido | number: 2%}</td>
            <td><i style="color: green" class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="row.bajalinea" output-prop-name="linea" ng-click="$ctrl.activarArticuloSiNo($event, row)" ng-class="{'fa-toggle-on': row.bajalinea == 0, 'fa-toggle-off': row.bajalinea == 1}"></i></td>
        </tr>

    </tbody>
    <tfoot>

    </tfoot>
</table>

</div>      
</div>

<div class="modal-footer">
	<button class="btn btn-outline-secondary" ng-click="$ctrl.guardarLinea($event)">Añadir</button>
 	<button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>