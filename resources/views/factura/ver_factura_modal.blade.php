
<div class="modal-header">
  <h5> Factura {% $ctrl.numerofactura %}</h5> 

  <!--<button style="float: left;" type="button" class="btn btn-light" ng-click="$ctrl.informacionFinanciera($event, $ctrl.idalbaran)"><i class="fa fa-info-circle" aria-hidden="true"></i> Financiera</button>-->

</div>

<div class="modal-body " id="modal-body" style="padding: 30px;">
  <div class="row">
      <!--<div class="col-sm-2">
          <td ng-if="$ctrl.logoempresa != null"><img ng-if="$ctrl.logoempresa != null" style="width: 100px;" ng-src="{% $ctrl.logoempresa %}" class="img-responsive"></td>
          <td ng-if="$ctrl.logoempresa == null"><img ng-if="$ctrl.logoempresa == null" style="width: 100px;" ng-src="img/sinImagen.jpg" class="img-responsive" ></td>  
      </div>-->
      <div class="col-sm-6">
          <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr>
                   <th>Cliente</th>
                   <th>Cif</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{% $ctrl.razonsocial %}</td>
                      <td>{% $ctrl.cifdni%}  </td>
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
                    <th style="text-align: right;">Factura</th>
                    <th>Tipo</th>
                   </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>{% $ctrl.fechafactura %} </td>
                    <td style="text-align: right;">{% $ctrl.numerofactura%} </td>
                    <td>{% $ctrl.tipo %} </td> 
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
              <th style="width: 28%;">Artículo</th>
              <th style="width: 3%; text-align: right;">Unidades</th>
              <th style="width: 4%; text-align: right;">Precio €</th>
              <th style="width: 3%; text-align: right;">Dto %</th>
              <th style="width: 3%; text-align: right;">IVA%</th>
              <th style="text-align: right; width: 3%;">Importe €</th>
              
          </tr>
      </thead>
      <tbody>
          <tr ng-repeat="row in articulo">
             <td style="text-align: right;">{%row.codigoarticulo%}</td>
             <td>{%row.descripcionarticulo%} <br ng-if="row.descripcionlinea != null"><span ng-if="row.descripcionlinea != null" style="font-size: 12px">* {%row.descripcionlinea.substr(0,140) %}</span><span ng-if="row.descripcionlinea.length > 140"> (<a href="#" ng-click="$ctrl.leerMas($event, row.descripcionlinea)">...</a>)</span></td>
             <td style="text-align: right;">{%row.unidades%}</td>
             <td style="text-align: right;">{%row.precio | number:2%}</td>
             <td style="text-align: right;">{%row.pordescuento%}</td>
             <td style="text-align: right;">{%row.poriva | number:2%}</td>
             <td style="text-align: right;">{%row.importeneto | number:2%}</td>
          </tr>
      </tbody>
      <tfoot>

      </tfoot>
  </table>

  </div>

  <div class="row">
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
                  <tr ng-repeat="row in ivas">
                      <td>{% row.tipoiva %}</td>
                      <td style="text-align: right;">{% row.baseimponible  | number:2%}</td>
                      <td style="text-align: right;">{% row.poriva | number:2%}</td>
                      <td style="text-align: right;">{% row.cuotaiva | number:2%}</td>
                  </tr>
                 

              </tbody>
          </table>
        </div> 
      </div>
     
      <div class="col-sm-6" >
            <div class="row" style="margin: 0px;">
              <div class="col">
                  <p><strong>Importe bruto</strong></p>
                  <p ng-if="$ctrl.pordescuento > 0"><strong>Dto ({% $ctrl.pordescuento | number:0%}%)</strong></p>
                  <p><strong>Base imponible</strong></p>
                  <p><strong>Total I.V.A</strong></p>
                  <p ng-if="$ctrl.importerecargo > 0"><strong>Recargo</strong></p>
                  <p ng-if="$ctrl.subtotal > 0"><strong>SubTotal</strong></p>
                    <p ng-if="$ctrl.importeretencion > 0"><strong>Retención ({% $ctrl.porretencion | number:0%}%)</strong></p>
                  <p><strong>Total factura</strong></p>
              </div>
              <div class="col">
                <P style="text-align: right;">{% $ctrl.importenetolineas | number:2%}</P>
                <P ng-if="$ctrl.pordescuento > 0" style="text-align: right;">{% $ctrl.importedescuento | number:2%}</P>
                <P style="text-align: right;">{% $ctrl.baseimponible | number:2%}</P>
                <P style="text-align: right;">{% $ctrl.totaliva | number:2%}</P>
                <P ng-if="$ctrl.importerecargo > 0" style="text-align: right;">{% $ctrl.importerecargo | number:2%}</P>
                <P ng-if="$ctrl.subtotal > 0" style="text-align: right;">{% $ctrl.subtotal | number:2%}</P>
                <P ng-if="$ctrl.importeretencion > 0" style="text-align: right;">{% $ctrl.importeretencion | number:2%}</P>
                <P style="text-align: right;"><strong>{% $ctrl.importeliquido | number:2%}</strong></P>
              </div>
            </div>

      </div>
  </div>
  <div class="row" ng-if="$ctrl.observacionesfactura != ''">
    <div class="col-sm-12">
     <label for="comment">Observaciones</label>
     <textarea class="form-control" rows="2" id="observacionesfactura" ng-model="$ctrl.observacionesfactura" maxlength="150"></textarea>
    </div>
  </div>

</div>
<div class="modal-footer">
<i style="font-size: 22px;" class="fa fa-spinner fa-pulse fa-3x fa-fw" ng-if="$ctrl.loading"></i>
<span ng-if="$ctrl.loading" class="sr-only">Loading...</span>
 <button class="btn btn-secondary" ng-click="$ctrl.crearPdf($event)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
 
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>

<script type="text/ng-template" id="datos-financieros-modal.html">
        @include('factura.datos_financieros_modal')
</script>
