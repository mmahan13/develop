
<div class="modal-header">
  <h4>Editar</h4>
</div>
<div class="modal-body " id="modal-body" >
  <table class="table table-hover">
    <thead>
        <tr>
          <th >F.inicio</th>
            <th >F.final</th>
            <th >Descripción</th>
            <th style="text-align: right;" >Uds</th>
            <th style="text-align: right;" >Precio €</th>
            <th style="text-align: right;" >Dto %</th>
            <th style="text-align: right;" >Dto €</th>
            <th style="text-align: right;" >IVA %</th>
            <th style="text-align: right;" >Importe €</th>
          </tr>    
    </thead>
    <tbody>
          <tr>
            <td>{% $ctrl.fechainicio %}</td>
            <td>{% $ctrl.fechafinal %}</td>
            <td>{% $ctrl.descripcionarticulo %}</td>
            <td style="text-align: right;"><input style="float: right;width: 80px;text-align: right;" type="number" class="form-control" name="unidades" class="form-control" id="unidades"  ng-model="$ctrl.unidades" min="1"></td>
            <td style="text-align: right;"><input style="float: right;width:100px;text-align: right;" type="text" class="form-control" name="precio" class="form-control" id="precio"  ng-model="$ctrl.precio" ng-value="$ctrl.precio" min="1" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" ></td>
            <td style="text-align: right;"><input style="float: right;width: 80px;text-align: right;" type="number" class="form-control" name="pordescuento" class="form-control" id="pordescuento"  ng-model="$ctrl.pordescuento" min="0"></td>
            <td style="text-align: right;">{% $ctrl.descuento | number:2%}</td>
            <td style="text-align: right;">{% $ctrl.poriva | number:0%}</td>
            <td style="text-align: right;">{% $ctrl.importe | number:2 %}</td>
    </tbody>
  </table>
</div> 
<div class="modal-footer">
 <button class="btn btn-outline-secondary" ng-click="$ctrl.guardarCambiosLineaContrato($event)">Guardar</button>
 <button class="btn btn-secondary" ng-click="$ctrl.cancel($event)">Cerrar</button>
</div>
