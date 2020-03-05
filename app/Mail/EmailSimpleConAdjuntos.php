<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSimpleConAdjuntos extends Mailable //implements ShouldQueue
{

    public $asunto;
    public $mensaje;
    public $saludo;
    public $razonsocial;
    public $numerofactura;
    public $idioma;
    public $adjunto;
    public $historico;

    public function __construct($adjunto, $to_name, $numerofactura, $idioma)
    {
        $this->adjunto = $adjunto;
        $this->razonsocial = $to_name;
        $this->facturanumero = $numerofactura;
        $this->idioma = $idioma;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $adjunto = storage_path('app/'.$this->adjunto);
        //$asunto = '['.$this->empresa->nombre . '] ';
        if($this->idioma == 'ES'){
            $this->saludo = 'Estimado/a';
            $this->mensaje =['Le adjuntamos en el presente correo nuestra factura número  '.$this->facturanumero.' en formato pdf.','Reciba un cordial saludo.'];
            $asunto = 'Factura Nº '.$this->facturanumero.' - Tu factura';
            $this->historico = 'Ver histórico de facturas';
        }else{
            $this->saludo = 'Dear';
            $this->mensaje = ['Please, find attached a new invoice, number '.$this->facturanumero.', in pdf format','Faithfully.'];
            $asunto = 'Invoice Nº '.$this->facturanumero.' - Turbo Master';
            $this->historico = 'Invoice history';
        }


        $from_email_empresa = config('mail.from_facturas.address');
        $from_name_empresa = config('mail.from_facturas.name'); 
      
        
        return $this->view('emails.simple_con_adjuntos')
            ->from($from_email_empresa, $from_name_empresa)
            ->with(['mensaje' => $this->mensaje])
            ->with(['saludo' => $this->saludo])
            ->with(['razonsocial' => $this->razonsocial])
           // ->bcc($bcc_mantenimiento)
            ->subject($asunto)
            ->attach($adjunto);
           
    }
}