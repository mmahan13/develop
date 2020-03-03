@extends('layouts.pdf')
@section('content')

<div class="cabecera_parte">
    <div class="cabecera_izq">
 
        <table id="tabla_cliente">
            <tbody>
                <tr>
                    <td>
                        <p style="font-size: 35px; margin-bottom:5px; font-weight:bold;">FACTURA</p>
                        <span class="label_parrafo">CLIENTE: </span> {{ $datos_factura['razonsocial'] or null }}<br/>
                        <span class="label_parrafo">CIF: </span> {{ $datos_factura['cifdni'] or null }}<br/>  
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
                        <th>Factura Nº</th>
                        <th>Página</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center">{{ $datos_factura['fechafactura'] or null }}</td>
                        <td style="text-align: center">{{ $datos_factura['numerofactura'] or null }}</td>
                        <td style="text-align: center">
                            1
                        </td>
                    </tr>
                    </tbody>
                </table>
                 <table>
                    <tbody>
                    <tr>
                        <td class="td-texto">{{ $datos_factura['razonsocial'] or null }}</td>
                    </tr>
                    <tr>
                        <td class="td-texto">{{ $datos_factura['cifdni'] or null }}</td>
                    </tr>
                    {{--<tr>
                        <td class="td-texto">{{$datos_factura['domicilio']}}</td>
                    </tr>--}}
                    </tbody>
                </table>
        </div>       
    </div>
</div>


    <!-- FIN Cabecera factura-->
    <!-- Cuerpo factura -->
    @if(count($articulos) < 11)
    <div class="" style=" border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;margin-bottom: 0.5cm;height: 14cm;width: auto; ">
    @elseif(count($articulos) > 10)
     <div class="" style=" border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;margin-bottom: 0.5cm;height: auto;width: auto;">    
    @endif    
        <table class="items">
            <thead>
            <tr>
                <th style="text-align: center">Artículo</th>
                <th style="text-align: center">Descripción</th>
                <th style="text-align: center">Cantidad</th>
                <th style="text-align: center">Precio</th>
                <th style="text-align: center">Dto</th>
                <th style="text-align: center">G. IVA</th>
                <th style="text-align: center">Importe</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articulos as $articulo)
                <tr>
                    <td>{{$articulo['codigoarticulo']}}</td>
                    <td class="align-left">{{$articulo['descripcionarticulo']}}</td>
                    <td>{{$articulo['cantidad']}}</td>
                    <td>{{$articulo['precioventa']}}</td>
                    <td>{{$articulo['descuento']}}%</td>
                    <td>{{$articulo['poriva']}}%</td>
                    <td>{{$articulo['liquidolinea']}}</td>

                </tr>
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
                            <tr>
                                <td>{{ $totaliva['tipoiva'] or null }}</td>
                                <td>{{ $totaliva['total_importe'] or null }}</td>
                                <td>{{ $totaliva['porcentaje'] or null }}</td>
                                <td>{{ $totaliva['total_iva'] or null }}</td>
                            </tr>
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
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['importebruto']}}</td>
                            </tr> 

                            @if($datos_factura['pordescuento'] > 0)   
                             <tr>
                                <td class="cm4" style="text-align: left">DTO ({{$datos_factura['pordescuento']}} %)</td>
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['importedescuento']}}</td>
                            </tr> 
                            @endif
                           
                            <tr>
                                <td class="cm4" style="text-align: left">BASE IMPONIBLE</td>
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['baseimponible']}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left">TOTAL I.V.A.</td>
                                <td style="text-align: right;" class="align-left">{{$datos_factura['totaliva']}}</td>
                            </tr>

                            @if($datos_factura['importerecargo'] > 0)   
                             <tr>
                                <td class="cm4" style="text-align: left">RECARGO</td>
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['importerecargo']}}</td>
                            </tr> 
                            @endif
                            @if($datos_factura['importerecargo'] > 0)   
                             <tr>
                                <td class="cm4" style="text-align: left">SUBTOTAL</td>
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['subtotal']}}</td>
                            </tr> 
                            @endif

                            @if($datos_factura['porretencion'] > 0)   
                             <tr>
                                <td class="cm4" style="text-align: left">RETENCIÓN ({{$datos_factura['porretencion']}} %)</td>
                                <td style="text-align: right;" class="align-left cm3">{{$datos_factura['importeretencion']}}</td>
                            </tr> 
                            @endif

                            <tr>
                                <td style="text-align: left">TOTAL FACTURA</td>
                                <td style="text-align: right;" class="align-left">{{$datos_factura['importeliquido']}}</td>
                            </tr>

                        </tbody>
                </table>
        </div>       
    </div>
</div>
 {{--@if($datos_factura['observaciones'] != null)
<div style="width:100%">
    Observaciones: {{ $datos_factura['observaciones'] }}
       
</div>
@endif--}}


</div>
@endsection