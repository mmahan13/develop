@extends('layouts.app')
@section('content')
    <div class="container">
        <legend>Su conexión a expirado por favor vuelva a iniciar sesión</legend>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-center">
                <form action="{{url('/')}}" method="get" role="form">
                    <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
                </form>
            </div>
        </div>
    </div>
@endsection
