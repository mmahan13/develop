<?php

namespace App\Http\Controllers;

use App\libraries\PdfInvoice;
use App\libraries\PdfOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSimpleConAdjuntos;


class PdfController extends Controller
{
   
    /**
     * @param string $invoice
     * @param null $path
     * @return mixed
     */
    public static function getPdfInvoice(Request $request)
    {
        $path = null;
        $d['cabecera'] = $request['facturacabecera'];
        $d['lineas'] = $request['articulos'];
        $d['totalesiva'] = $request['totalesiva'];
        
        // Make PDF file
        $pdf = new PdfInvoice();
        $pdf->LoadData($d);
        $pdf->AddPage();
        $pdf->bodyTable();
        if ($path != null) {
            $pdf->Output($path, 'F');
        } else {
            $pdf->Output();
            exit();
        }
        return response()->json('listo');
        //        return print_r($invoice_content,true);

    }

    public static function reeviarFactura(Request $request)
    {
        $d['cabecera'] = $request['facturacabecera'];
        $d['lineas'] = $request['articulos'];
        $d['totalesiva'] = $request['totalesiva'];

        
        $pdf = new PdfInvoice();
        $pdf->LoadData($d);
        $pdf->AddPage();
        $pdf->bodyTable();

        $to_factura = $d['cabecera']['numerofactura'].'/'. $d['cabecera']['seriefactura'];
        $pdf_name = 'Factura_'.$d['cabecera']['numerofactura'].'_'.$d['cabecera']['seriefactura'].'.pdf';
    

        $directory = "public/";
        $pdf->Output(storage_path('app/') . $directory . $pdf_name, 'F');
        $adjunto = $directory.$pdf_name;
      
      
        if(!isset($d['cabecera']['email'])){
            $d['cabecera']['email'] = auth()->user()->email;
        }
    
        $bcc_mantenimiento = config('mail.bcc_mantenimiento.address');
       
        if(filter_var($d['cabecera']['email'], FILTER_VALIDATE_EMAIL))
        {
            Mail::to($d['cabecera']['email'])
            ->bcc($bcc_mantenimiento)
            ->send(new EmailSimpleConAdjuntos($adjunto, $d['cabecera']['razonsocial'], $to_factura, 'ES'));
            
            $response = [
                'envio' => 'Enviado',
                'message' => [],
            ];
            return json_encode($response);
        }

       

       

    }

    /**
     * @param string $offer
     */
    public function getPdfOffer(string $idoferta, string $company)
    {
        $d['cabecera'] = \DB::select('exec portal_turbomaster_cli.cli.listar_cabeceraoferta ?', [$idoferta]);
        $d['lineas'] = \DB::select('exec portal_turbomaster_cli.cli.listar_lineasoferta ?', [$idoferta]);


        // Make PDF file
        $pdf = new PdfOffer();
        $pdf->LoadData($d);
        $pdf->AddPage();
        $pdf->bodyTable();
        $pdf->Output();
        exit();
        //        return response()->json($offer_content);
    }



    /**
     * @param string $contract
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPdfContract(string $contract, string $company)
    {
        $contract_content = [];
        $contract_content['number'] = $contract;
        $contract_content['codigoEmpresa'] = $company;
        //        $contract_content['url'] = QrCodeController::getQrCodeFromUrl($request->url(), $contract);
        // $erp = ERP::find(2); // External connection previously saved in the ERP model, searched by id
        // $action = Action::where('name', 'datos_cliente_contrato_murano')->first();
        // $contract_content['client'] = json_decode($this->executeExternalQuery($erp, $action, [$contract])
        //    ->getContent(), true)['message'][0];
        $contract_content['client'] = collect(\DB::select('exec portal_master_users.cli.datos_cliente_contrato_murano ?', [$contract]))->first();
        // $action = Action::where('name', 'lineas_contrato_murano')->first();
        // $contract_content['lines'] = json_decode($this->executeExternalQuery($erp, $action, [$contract])
        //    ->getContent(), true)['message'];
        $contract_content['lines'] = collect(\DB::select('exec portal_master_users.cli.lineas_contrato_murano ?, ?', [$contract, $company]));
        // Make PDF File
        $pdf = new PdfContract();
        $pdf->LoadData($contract_content);
        $pdf->AddPage('Landscape');
        $pdf->bodyTable();
        $pdf->Output();
        //        \File::delete(public_path() . $contract_content['url']);
        exit();
        //        return response()->json($contract_content);
    }

}
