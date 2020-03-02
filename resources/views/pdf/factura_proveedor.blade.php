@extends('layouts.pdf')
@section('content')

<div class="cabecera_parte">
    <div class="cabecera_izq">
      
        <table id="tabla_cliente">
            <tbody>
                <tr>
                    <td>
                        <p style="font-size: 35px; margin-bottom:5px; font-weight:bold;">Factura</p>
                        <span class="label_parrafo">CLIENTE: </span> {{ $cabecera_presupuesto['razonsocial'] or null }}<br/>
                        <span class="label_parrafo">CIF: </span> {{ $cabecera_presupuesto['cifdni'] or null }}<br/>  
                    </td>
                </tr>
            </tbody>
        </table>
       
    </div>
   
    <div class="cabecera_der">
        <div class="info_cliente">
            <table>
                  <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Factura</th>
                        <th>Página</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center">{{ $cabecera_presupuesto['fechafactura'] or null }}</td>
                        <td style="text-align: center">{{ $cabecera_presupuesto['serie'] or null }}</td>
                        <td style="text-align: center">{{ $cabecera_presupuesto['numerofactura'] or null }}</td>
                        <td style="text-align: center">
                            1
                        </td>
                    </tr>
                    </tbody>
                </table>
                 <table>
                    <tbody>
                    <tr>
                        <td class="td-texto">{{ $cabecera_presupuesto['razonsocial'] or null }}</td>
                    </tr>
                    <tr>
                        <td class="td-texto">{{ $cabecera_presupuesto['cifdni'] or null }}</td>
                    </tr>
                    {{--<tr>
                        <td class="td-texto">{{$cabecera_presupuesto['domicilio']}}</td>
                    </tr>--}}
                    </tbody>
                </table>
        </div>       
    </div>
</div>


    <!-- FIN Cabecera factura-->
    <!-- Cuerpo factura -->
    @if(count($articulos) < 11)
    <div class="" style=" border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;margin-bottom: 0.5cm;height: 15cm;width: auto; ">
    @elseif(count($articulos) > 10)
     <div class="" style=" border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;margin-bottom: 0.5cm;height: auto;width: auto;">    
    @endif    
        <table class="items">
            <thead>
            <tr>
                <th style="text-align: center">Cod</th>
                <th style="text-align: center">Descripción</th>
                <th style="text-align: center">uds</th>
                <th style="text-align: center">Precio</th>
                <th style="text-align: center">Dto</th>
                <th style="text-align: center">Dto</th>
                <th style="text-align: center">IVA</th>
                <th style="text-align: center">Importe</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articulos as $articulo)
                @if($articulo['precio'] > 0)
                <tr>
                    <td>{{$articulo['codigoarticulo']}}</td>
                    <td class="align-left">
                        {{$articulo['descripcionarticulo']}}
                         @if($articulo['descripcionlinea'] != null)
                            <br> * {{$articulo['descripcionlinea']}}
                         @endif
                    </td>
                    <td>{{$articulo['unidades']}}</td>
                    <td>{{money_format("%.2n", $articulo['precio'])}}</td>
                    <td>{{$articulo['pordescuento']}}%</td>
                    <td>{{$articulo['importedescuento']}}€</td>
                    <td>{{$articulo['poriva']}}</td>
                    <td>{{money_format("%.2n", $articulo['importeneto'])}}</td>

                </tr>
                @endif
            </tbody>
            @endforeach
        </table>
    </div>
    @if(count($articulos) > 28)
        <hr style="border: none">
        <p style="text-align: right; margin-top:30px"></p>
     
    @endif
    <!-- FIN Cuerpo factura-->

<div class="pie_parte">
    <div class="footer_izq">
        <table>
               <thead>
                    <tr>
                        <th >G.IVA</th>
                        <th >BASE IMPONIBLE</th>
                        <th >% IVA</th>
                        <th >TOTAL IVA</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($totalesiva as $totaliva)
                        @if($totaliva['baseimponible']>0)
                            <tr>
                                <td>{{ $totaliva['tipoiva'] or null }}</td>
                                <td>{{ $totaliva['baseimponible'] or null }}</td>
                                <td>{{ $totaliva['poriva'] or null }}</td>
                                <td>{{ $totaliva['cuotaiva'] or null }}</td>
                               
                            </tr>
                        @endif        
                    @endforeach
                    </tbody>
            </table>
       
    </div>

    <div class="footer_der">
        <div class="info_cliente">
            
                 <table>
                   <tbody>
                            <tr>
                                <td class="cm4" style="text-align: left">IMPORTE BRUTO</td>
                                <td style="text-align: right;" class="align-left cm3">{{money_format("%.2n",$cabecera_presupuesto['importebruto'])}}</td>
                            </tr>    
                            <tr>
                                <td class="cm4" style="text-align: left">BASE IMPONIBLE</td>
                                <td style="text-align: right;" class="align-left cm3">{{money_format("%.2n", $cabecera_presupuesto['importenetolineas'])}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left">TOTAL I.V.A.</td>
                                <td style="text-align: right;" class="align-left">{{money_format("%.2n",$cabecera_presupuesto['cuotaiva'])}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left">TOTAL FACTURA</td>
                                <td style="text-align: right;" class="align-left">{{money_format("%.2n",$cabecera_presupuesto['importeliquido'])}}</td>
                            </tr>

                        </tbody>
                </table>
        </div>       
    </div>
</div>
{{-- @if($cabecera_presupuesto['observaciones'] != null)
<div style="width:100%">
    Observaciones: {{ $cabecera_presupuesto['observaciones'] }}
       
</div>
@endif  --}}


</div>
@endsection