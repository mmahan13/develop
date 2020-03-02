@extends('layouts.left_panel')
@section('left-menu')
    <div class="accordion" id="accordionUsers">
        <div class="card nsc-card-left-menu">
            <div class="card-header nsc-head-left-menu" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn nsc-btn-left-menu" type="button" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                        Usuarios
                    </button>
                </h5>
            </div>
            <div id="collapseUsers" class="collapse" aria-labelledby="headingOne" data-parent="#accordionUsers">
                <div class="card-body">
                    <section-menu-item item-name="users.users" inner-text="Listado"></section-menu-item>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionRoles">
        <div class="card nsc-card-left-menu">
            <div class="card-header nsc-head-left-menu" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn nsc-btn-left-menu" type="button" data-toggle="collapse" data-target="#collapseRoles" aria-expanded="true" aria-controls="collapseRoles">
                        Perfiles
                    </button>
                </h5>
            </div>
            <div id="collapseRoles" class="collapse" aria-labelledby="headingOne" data-parent="#accordionRoles">
                <div class="card-body">
                    <section-menu-item item-name="roles.roles" inner-text="Listado"></section-menu-item>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionPaths">
        <div class="card nsc-card-left-menu">
            <div class="card-header nsc-head-left-menu" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn nsc-btn-left-menu" type="button" data-toggle="collapse" data-target="#collapsePaths" aria-expanded="true" aria-controls="collapsePaths">
                        Permisos
                    </button>
                </h5>
            </div>
            <div id="collapsePaths" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPaths">
                <div class="card-body">
                    <section-menu-item item-name="permissions.permissions" inner-text="Rutas"></section-menu-item>
                </div>
            </div>
        </div>
    </div>
      
@endsection
