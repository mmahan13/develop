
            <div class="card">
                <div class="card-header">Registrarse</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        <div class="form-group">
                        <label for="password" class="col-md-12 col-form-label">Email</label>
                            <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" ng-model="$lCtrl.email" name="email"  placeholder="suemail@gmail.com" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="password" class="col-md-12 col-form-label">Contraseña</label>
                            <div class="col-md-12">
                            <input id="password" type="password" class="form-control" ng-model="$lCtrl.password" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-12 col-form-label">Razon social</label>
                            <div class="col-md-12">
                                <input id="razonsocial" type="text" class="form-control" name="razonsocial" ng-model="$lCtrl.razonsocial" placeholder="Su nombre o su empresa" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-12 col-form-label">Apellidos</label>
                            <div class="col-md-12">
                                <input id="apellidos" type="text" class="form-control" name="apellidos" ng-model="$lCtrl.apellidos"   placeholder="Si ha puesto nombre ponga apellidos." autofocus>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-right:0px; margin-left:0px;">
                            <div class="col-sm-6">
                                <label for="password" class="col-form-label">CIF/DNI</label>
                                    <input id="dni" type="text" class="form-control" name="dni" ng-model="$lCtrl.dni"  placeholder="CIF o DNI" required autofocus>
                            </div>
                            <div class="col-sm-6">
                                <label for="password" class="col-form-label">Telefono</label>
                                    <input id="telefono" type="text" class="form-control" name="telefono"  ng-model="$lCtrl.telefono" placeholder="Movil o fijo" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="textarea" class="col-md-12 col-form-label">Dirección</label>
                            <div class="col-md-12">
                             <textarea class="form-control" id="direccion"  name="direccion" rows="3" ng-model="$lCtrl.direccion" placeholder="Direccion completa, CP, Ciudad, Provincia y País" required autofocus></textarea>
                            </div>
                        </div>


                        <div class="form-group mb-0">
                            <div class="col-md-12 ">
                                <button type="button" class="btn btn-success float-right" ng-click="$lCtrl.guardarDatos($event)">
                                   Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
      