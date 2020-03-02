<div class="modal-header">
  <h4>Editar</h4>
</div>
<div class="modal-body " id="modal-body" >
  <table class="table table-hover">
    <thead>
        <tr>
            <th style="text-align: right;" >Importe bruto €</th>
            <th style="text-align: right;" >Dto %</th>
            <th style="text-align: right;" >Dto €</th>
            <th style="text-align: right;" >Base imponible €</th>
            <th style="text-align: right;" >Total IVA €</th>
            <th style="text-align: right;" >Total contrato €</th>
          </tr>    
    </thead>
    <tbody>
          <tr>
              <td style="text-align: right;" >{% $ctrl.importenetolineas | number:2 %}</td>
              <td style="text-align: right;"><input style="float: right;width: 100px;text-align: right;" type="number" class="form-control" name="pordescuento" class="form-control" id="pordescuento"  ng-model="$ctrl.pordescuento" min="0"></td>
              <td style="text-align: right;">{% $ctrl.importedescuento | number:2%}</td>
              <td style="text-align: right;">{% $ctrl.importeneto | number:2%}</td>
              <td style="text-align: right;">{% $ctrl.totaliva | number:2 %}</td>
              <td style="text-align: right;">{% $ctrl.importeliquido | number:2 %}</td>
          </tr>    
    </tbody>
  </table>
</div> 
<div class="modal-footer">
 <button class="btn btn-outline-secondary" ng-click="$ctrl.guardarCambiosCabeceraContrato($event)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
