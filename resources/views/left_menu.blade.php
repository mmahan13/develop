@extends('layouts.left_panel')
@section('left-menu')


 <div class="nsc-left-menu">
        <!--<menu-element name="Articulos" default="">
            <menu-item name="Listado" panel="lista_articulos"></menu-item>
        </menu-element>-->
         <menu-element name="Menu" default="listado_usuarios">
                <menu-item name="Mis clientes" panel="listado_usuarios"></menu-item>
                <menu-item name="Mis productos" panel="lista_articulos"></menu-item>
                <menu-item name="Crear factura" panel="nueva_factura"></menu-item>
                <menu-item name="Listado Facturas" panel=" listado_facturas_clientes"></menu-item>
        </menu-element>
       
        
       <!-- <menu-element name="Compras" default="">
                <menu-item name="Proveedores" panel="listado_proveedores"></menu-item>
                <menu-item name="Factura" panel="nuevo_presupuesto"></menu-item>
        </menu-element>
        <menu-element name="Ventas" default="">
               <menu-item name="Facturas" panel="listado_facturas_clientes"></menu-item>
               <menu-item name="Ofertas" panel="listado_ofertas_clientes"></menu-item>
        </menu-element>-->
        <!--<menu-element name="Factura" default="">
                <menu-item name="Listado" panel="lista_clientes"></menu-item>
                <menu-item name="Artículos" panel="lista_articulos"></menu-item>
                <menu-item name="Contratos" panel="contratos"></menu-item>
                <menu-item name="Oferta" panel="nueva_oferta"></menu-item>
                <menu-item name="Factura" panel="nueva_factura"></menu-item>
        </menu-element>-->
         <!-- <menu-element name="Resumen" default="">
                <menu-item name="Resumen IVA" panel="resumen_iva"></menu-item>
        </menu-element>
      <menu-element name="Contratos" default="">
                <menu-item name="listado contratos" panel="listado_contratos"></menu-item>
                <menu-item name="Facturar contratos" panel="pendientes_facturacion"></menu-item>
        </menu-element>-->
    </div>

   

@endsection
