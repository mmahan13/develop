
<div class="modal-header">
  <h4>Gasto</h4>
 </div>

<div class="modal-body " id="modal-body">
  <div class="row">
    <div class="col-sm-12">
          <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr>
                   <th>Proveedor</th>
                   <th>CIF</th>
                   <th>Fecha</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{% $ctrl.razonsocial %}</td>
                      <td>{% $ctrl.cifdni%}</td>
                      <td>{% $ctrl.fechafactura %} </td>
                  </tr>
              </tbody>
          </table>
          </div>
          
      </div>
  </div>

  <div class="table-responsive" >
  <table id="my-table" class="table">
      <thead>
          <tr>
              <th style="width: 1%; text-align: right;">Cod</th>
              <th style="width: 28%;">Descripción</th>
              <th style="width: 3%; text-align: right;">Uds</th>
              <th style="width: 4%; text-align: right;">Precio</th>
              <th style="text-align: right; width: 3%;">Total</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <td style="text-align: right;">{%$ctrl.codigoarticulo%}</td>
            <td>{%$ctrl.descripcionfactura%}</td>
            <td style="text-align: right;">1</td>
            <td style="text-align: right;">{%$ctrl.precio | number:2%}</td>
            <td style="text-align: right;">{%$ctrl.precio | number:2%}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td style="text-align:right;" colspan="3">Total Gasto: <strong>{% $ctrl.precio | number:2%}</strong></td>
          </tr>
      </tbody>
  </table>

  </div>
</div> 

<div class="modal-footer">
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>


