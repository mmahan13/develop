@extends('layouts.right_panel')
@section('panel-tilte')
    Listado de Permisos de Rutas
@overwrite
@section('panel-content')
    <permissions-list></permissions-list>
    <script type="text/ng-template" id="permission-list.html">
        @include('permissions.permission_list')
    </script>
    <script type="text/ng-template" id="modal-permission-details.html">
        @include('permissions.permission_modal')
    </script>
    <script type="text/ng-template" id="modal-permission-add.html">
        @include('permissions.permission_add')
    </script>
@overwrite
