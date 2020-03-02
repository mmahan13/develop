
@extends('layouts.app')

@section('content')
<div class="container-fluid crm-new">
    <div class="row">
        <div class="col-lg-2">
            @include('left_menu')
        </div>
        
        @include('Usuarios.listado_usuarios')
        @include('articulos.lista_articulos')
        @include('factura.nueva_factura')
        @include('factura.listado_facturas')
        
    </div>
</div>
@endsection

