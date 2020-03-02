
<div class="modal-header">
  <h4>Factura</h4>
  <button type="button" class="close" data-dismiss="modal"ng-click="$ctrl.cancel($event)">
          <span aria-hidden="true">&times;</span>
        </button>
</div>

<div class="modal-body " id="modal-body">
  <div class="row">
    <div class="col-sm-6">
          <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr>
                   <th>Proveedor</th>
                   <th>CIF</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{% $ctrl.razonsocial %}</td>
                      <td>{% $ctrl.cifdni%}</td>
                  </tr>
              </tbody>
          </table>
          </div>
          
      </div>
      <div class="col-sm-6">
          <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr> 
                      <th>Fecha</th>
                      <th style="text-align: right;">Serie</th>
                      <th style="text-align: right;">Factura</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{% $ctrl.fechafactura %} </td>
                      <td style="text-align: right;">{% $ctrl.serie%} </td>
                      <td style="text-align: right;">{% $ctrl.numerofactura%} </td>
                  </tr>
              </tbody>
          </table>
          </div>
      </div>
    </div>

  <div class="table-responsive" >
  <table id="my-table" class="table" st-table="articulo" st-safe-src="$ctrl.articulos">
      <thead>
          <tr>
              <th style="width: 1%; text-align: right;">Cod</th>
              <th style="width: 28%;">Descripción</th>
              <th style="width: 3%; text-align: right;">Unidades</th>
              <th style="width: 4%; text-align: right;">Precio €</th>
              <th style="width: 3%; text-align: right;">Dto %</th>
              <th style="width: 3%; text-align: right;">Dto €</th>
              <th style="width: 3%; text-align: right;">IVA %</th>
              <th style="text-align: right; width: 3%;">Importe €</th>
              
          </tr>
      </thead>
      <tbody>
          <tr ng-repeat="row in articulo" ng-if="row.precio > 0">
             <td style="text-align: right;">{%row.codigoarticulo%}</td>
              <td>{%row.descripcionarticulo%} <br ng-if="row.descripcionlinea != ''"><span ng-if="row.descripcionlinea != ''" style="font-size: 12px">* {%row.descripcionlinea.substr(0,140)%}</span><span ng-if="row.descripcionlinea.length > 140"> (<a href="#" ng-click="$ctrl.leerMas($event, row.descripcionlinea)">...</a>)</span></td>
             <td style="text-align: right;">{%row.unidades%}</td>
             <td style="text-align: right;">{%row.precio  | number:2%}</td>
             <td style="text-align: right;">{%row.pordescuento%}</td>
             <td style="text-align: right;">{%row.importedescuento | number:2%}</td>
             <td style="text-align: right;">{%row.poriva%}</td>
             <td style="text-align: right;">{%row.importeneto  | number:2%}</td>
              
          </tr>

      </tbody>
      <tfoot>

      </tfoot>
  </table>

  </div>

  <div class="row" style="margin-bottom: 30px;">
      <div class="col-sm-6">
         <div class="table-responsive" >
          <table id="my-table-ivas" class="table" st-table="ivas" st-safe-src="$ctrl.totales_ivas">
              <thead>
                  <tr> 
                      <th>T.IVA</th>
                      <th style="text-align: right;">Base Imponible</th>
                      <th style="text-align: right;">%IVA</th>
                      <th style="text-align: right;">Total I.V.A</th>
                  </tr>
              </thead>
              <tbody>
                  <tr ng-repeat="row in ivas" ng-if="row.baseimponible > 0">
                      <td>{% row.tipoiva %}</td>
                      <td style="text-align: right;">{% row.baseimponible | number:2%}</td>
                      <td style="text-align: right;">{% row.poriva | number:0 %}</td>
                      <td style="text-align: right;">{% row.cuotaiva  | number:2 %}</td>
                  </tr>
                 

              </tbody>
          </table>
        </div> 
      </div>
     
      <div class="col-sm-6" >
            <div class="row" style="margin: 0px;">
              <div class="col">
                  <p><strong>Importe bruto</strong></p>
                  <p ng-if="$ctrl.importedescuento >0"><strong>Dto </strong> ({% $ctrl.pordescuento | number:0%}%)</p>
                  <p><strong>Base imponible</strong></p>
                  <p ng-if="$ctrl.importerecargo !=0"><strong>Recargo </strong></p>
                  <p><strong>Total I.V.A </strong></p>
                  <p ng-if="$ctrl.importeretencion !=0"><strong>SubTotal</strong></p>
                  <p ng-if="$ctrl.importeretencion !=0"><strong>Retención</strong> ({% $ctrl.porretencion|number:0%}%)</p>
                  <p><strong>Total factura </strong></p>
              </div>
              <div class="col">
                <P style="text-align: right;">{% $ctrl.importebruto  | number:2%}</P>
                <P ng-if="$ctrl.importedescuento >0"style="text-align: right;">{% $ctrl.importedescuento | number:2%}</P>
                <P style="text-align: right;">{% $ctrl.baseimponible  | number:2%}</P>
                <P ng-if="$ctrl.importerecargo !=0" style="text-align: right;">{% $ctrl.importerecargo  | number:2%}</P>
                <P style="text-align: right;">{% $ctrl.cuotaiva | number:2%}</P>
                <P ng-if="$ctrl.importeretencion !=0"style="text-align: right;">{% $ctrl.sindescuentoretencion  | number:2%}</P>
                <P ng-if="$ctrl.importeretencion !=0"style="text-align: right;">{% $ctrl.importeretencion  | number:2%}</P>
                <P style="text-align: right;"><strong>{% $ctrl.importeliquido  | number:2%}</strong></P>
              </div>
            </div>

      </div>
  </div>
   <div class="row" ng-if="$ctrl.observaciones != null">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="comment">Observaciones</label>
              <textarea class="form-control" rows="2" id="observaciones" ng-model="$ctrl.observaciones" maxlength="150"></textarea>
        </div>
    </div>
  </div>

</div> 

<div class="modal-footer">
  <i style="font-size: 22px;" class="fa fa-spinner fa-pulse fa-3x fa-fw" ng-if="$ctrl.loading"></i>
  <span ng-if="$ctrl.loading" class="sr-only">Loading...</span>
 <button ng-if="$ctrl.articulos.length > 0" class="btn btn-secondary" ng-click="$ctrl.crearPdfProveedor($event)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


