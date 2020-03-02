@extends('layouts.right_panel')
@section('panel-tilte')
    Listado de Roles
@overwrite
@section('panel-content')
    <roles-list></roles-list>
    <script type="text/ng-template" id="role-list.html">
        @include('roles.role_list')
    </script>
    <script type="text/ng-template" id="modal-role-details.html">
        @include('roles.role_modal')
    </script>
    <script type="text/ng-template" id="modal-role-add.html">
        @include('roles.role_add')
    </script>
@overwrite
