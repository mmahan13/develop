@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div ng-controller="adminController">
        <div class="row">
            <div class="col-md-2">
                @include('admin.left_menu')
            </div>
            <div class="col-md-10">
                <div class="" listener-panel="" event-name="left_menu_selection">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
