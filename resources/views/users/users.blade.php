@extends('layouts.right_panel')
@section('panel-tilte')
    Listado de Usuarios
@overwrite
@section('panel-content')
    <users-list></users-list>
    <script type="text/ng-template" id="user-list.html">
        @include('users.user_list')
    </script>
    <script type="text/ng-template" id="modal-user-details.html">
        @include('users.user_modal')
    </script>
    <script type="text/ng-template" id="modal-user-add.html">
        @include('users.user_add')
    </script>
@overwrite
