<?php

namespace App\Traits;
use DPDF;
use Carbon\Carbon;
use Mockery\Exception;


trait PdfTrait
{
    public function generar_factura($datos_factura, $totalesiva, $articulos)
    {
		try{
				setlocale(LC_MONETARY, 'es_ES.utf8');
				$pdf = DPDF::loadView('pdf/factura', [
		        	'datos_factura' => $datos_factura,
		        	'articulos' => $articulos,
		        	'totalesiva' => $totalesiva
		        ])->setPaper('a4', 'portrait');
		     	
		     	return $pdf->download( 'factura_'. date('Ydm_hi'). '.pdf');
	    	
    	}
        catch (Exception $e){
			return response("KO", 500);
        } 
        
    }

    public function generar_factura_proveedor($cabecera_presupuesto, $totalesiva, $articulos)
    {
		try{
		        setlocale(LC_MONETARY, 'es_ES.utf8');
				$pdf = DPDF::loadView('pdf/factura_proveedor', [
		        	'cabecera_presupuesto' => $cabecera_presupuesto,
		        	'articulos' => $articulos,
		        	'totalesiva' => $totalesiva
		        ])->setPaper('a4', 'portrait');
		     	
		     	return $pdf->download( 'factura_'. date('Ydm_hi'). '.pdf');
	    	
    	}
        catch (Exception $e){
			return response("KO", 500);
        } 
        
    }
}
