<div class="table-responsive">
  <table class="table table-hover" st-table="listado" st-safe-src="$lCtrl.contratos">
  		<thead>
  			<tr>
  				<th colspan="13">
  					<input st-search="" placeholder="Buscar..." class="form-control form-control-sm" type="search">
  				</th>
          <th colspan="2">
             <button style="float: right;" type="button" class="btn btn-light" ng-click="$lCtrl.exportarListadoContratos($lCtrl.contratos)">Exportar <i style="color:green" class="fa fa-file-excel-o" aria-hidden="true"></i></button>
          </th>
  				<th colspan="2">
  					<button style="float: right;" type="button" class="btn btn-secondary" ng-click="$lCtrl.nuevoContrato($event)">
	                     <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo contrato
	                </button>
  				</th>
         
  			</tr>
  		</thead>
        <thead>
        	<tr>
        	  <th>Activo</th>
        	  <th>Renueva</th>
            <th st-sort="">F.activación</th>
        	  <th st-sort="">F.inicio</th>
            <th st-sort="">F.final</th>
          	<th style="text-align: right;" st-sort="">Contrato</th>
          	<th st-sort="">Cliente</th>
            <th st-sort="">CIF</th>
            <th style="text-align: center;"st-sort="">Pago</th>
            <th style="text-align: right;" st-sort="">Plan €</th>
            <th style="text-align: right;" st-sort="">Anual €</th>
          	<th style="text-align: right;" st-sort="">impt bruto €</th>
          	<th style="text-align: right;" st-sort="">Dto.%</th>
          	<th style="text-align: right;" st-sort="">Dto.€</th>
          	<th style="text-align: right; width: 35%;" st-sort="">Base imponible€</th>
            <th style="text-align: right;  width: 7%;" st-sort="">Total IVA €</th>
            <th style="text-align: right;" st-sort="">Total €</th>
          </tr>    
        </thead>
        <tbody>
            <tr ng-repeat="row in listado" style="cursor: pointer;" ng-click="$lCtrl.datosContratos($event, row)">
            	<td style="text-align:center;"><i style="color:green; font-size: 23px" class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="row.estado" output-prop-name="estado" ng-click="$ctrl.activarContrato($event, row.idcontrato)" ng-class="{'fa-toggle-on': row.estado == 1, 'fa-toggle-off': row.estado == 0}"></i></td>
            	<td style="text-align:center;"><i style="color:green; font-size: 23px" class="fa fa-2x ng-isolate-scope ng-not-empty ng-valid fa-toggle-off" input-prop-name="active" ng-model="row.estado" output-prop-name="renueva" ng-click="row.renuevaContrato($event, row.idcontrato)" ng-class="{'fa-toggle-on': row.renueva == 1, 'fa-toggle-off': row.renueva == 0}"></i></td>
              <td ng-if="row.fechaactivacion != 'Invalid date'">{% row.fechaactivacion %}</td>
              <td ng-if="row.fechaactivacion == 'Invalid date'">--/--/----</td>
            	<td>{% row.fechacontrato %}</td>
       		  	<td>{% row.fechafinal %}</td>
            	<td style="text-align: right;">{% row.numerocontrato %}</td>
            	<td>{% row.razonsocial %}</td>
       			<td>{% row.cifdni %}</td>
       			<td style="text-align: center;">{% row.periodicidad %}</td>
            <td style="text-align: right;">{% row.importehistorico | number:2%}</td>
            <td style="text-align: right;">{% row.importeanual | number:2%}</td>
       			<td style="text-align: right;">{% row.importenetolineas | number:2 %}</td>
       			<td style="text-align: right;">{% row.pordescuento | number:0 %}</td>
       			<td style="text-align: right;">{% row.importedescuento | number:2 %}</td>
       			<td style="text-align: right;">{% row.importeneto | number:2 %}</td>
       			<td style="text-align: right;">{% row.totaliva | number:2 %}</td>
       			<td style="text-align: right;">{% row.importeliquido | number:2 %}</td>
       			
       			
            </tr>
        </tbody>
  </table>
</div>		  
