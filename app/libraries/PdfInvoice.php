<?php

namespace App\libraries;

use Anouar\Fpdf\Fpdf;


class PdfInvoice extends Fpdf
{
    const MAX_ROWS = 100;
    const InitialY = 75;
    /**
     * @var
     */
    protected $content;
    /**
     * @var bool
     */
    protected $multi_pages = false;
    protected $total_import;
    protected $current_margin;
    protected $total_iva = [0 => [], 1 => [], 2 => []];
    protected $footer;
    protected $creditocaucion = false;

    /**
     * Load Data to render invoice
     * @param array $invoice_content
     */
    public function LoadData(array $invoice_content)
    {
        
        $this->content = $invoice_content;
        $this->SetY(75);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
    }

    /**
     * Page Header
     */
    function Header()
    {
        
        
        //cabeceras
        $this->diraccionfacturacion = "Dirección facturación";
        $this->fechafactura = "Fecha Factura:";
        $this->numerofactura = "Nº Factura:";
        $this->pagina = "Página:";
        $this->observaciones = "Observaciones:";
        //tablaarticulos
        $this->referencia = "REFERENCIA";
        $this->descripcion ="DESCRIPCIÓN";
        $this->cantidad ="CANTIDAD";
        $this->preciounitario ="PRECIO";
        $this->pordescuento ="% Desc";
        $this->totaleuros ="TOTAL EUR";
            
        /*if($this->content['cabecera'][0]->seriefactura == 'TM'){
            $this->Image(public_path().'/img/logo_101.gif', 145, 8, 50, 22);
        }
        if($this->content['cabecera'][0]->seriefactura == 'TO'){
            $this->Image(public_path().'/img/logo202.gif', 145, 8, 50, 22);
        }
        if($this->content['cabecera'][0]->seriefactura == ''){
            $this->Image(public_path().'/img/logo_color.jpg', 135, 8, 65, 19);
        }*/
        
        
        $this->SetFont('Arial', 'B', 16);
        $this->Text(159,41, 'F');
        $this->Text(164,41, 'A');
        $this->Text(169,41, 'C');
        $this->Text(174,41, 'T');
        $this->Text(179,41, 'U');
        $this->Text(184,41, 'R');
        $this->Text(189,41, 'A');
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, utf8_decode('Manuel'), 0, 0, 'I');

        $this->Ln(5);
        $this->SetFont('Arial', 'B',11);
        $this->Cell(0, 5, utf8_decode('Fernandez Caballero'), 0, 0, 'I');


        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->Text(11,24, 'Dir.:');
        $this->SetFont('Arial', '', 9);
        $this->Text(20,24, utf8_decode('Calle de los militares 10, Burgos. España.'));
        
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->Text(11,28, 'CIF.:');
        $this->SetFont('Arial', '', 9);
        $this->Text(20,28, utf8_decode('V-56987456'));
        
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->Text(11,32, 'Tel.:');
        $this->SetFont('Arial', '', 9);
        $this->Text(20,32, utf8_decode('636118911'));
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->Text(11,36, 'Mail.:');
        $this->SetFont('Arial', '', 9);
        $this->Text(20,36, utf8_decode("manuel@gmail.com"));


        $this->clientAddress();

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(22, 6, utf8_decode($this->fechafactura), 0, 0, 'R');
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 6, utf8_decode($this->content['cabecera']['fechafactura']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 6, utf8_decode($this->numerofactura), 0, 0, 'R');
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 6, utf8_decode($this->content['cabecera']['numerofactura']), 0, 0, 'L');
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(23, 6, utf8_decode($this->observaciones), 0, 0, 'L');
        $this->Cell(60, 6, utf8_decode('falta observación'), 0, 0, 'L');
    }

    protected function clientAddress()
    {   
        $this->Line(10, 45, 210-10, 45);    
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(13, 6, 'Cliente.:', 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(16, 6, utf8_decode($this->content['cabecera']['razonsocial']), 0, 0, 'L');
        
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(13, 6, 'CIF:', 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(16, 6, utf8_decode($this->content['cabecera']['cifdni']), 0, 0, 'L');
        

        $this->Ln(4);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(13, 6, utf8_decode('Dirección:'), 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(19, 6, utf8_decode('Calle de la libertad 11'), 0, 0, 'L');
        $this->Line(10, 63, 210-10, 63);
    }



    /**
     * Page Footer
     */
    function Footer()
    {
       
        if ($this->footer)
        {
            $this->SetY(250);
            $this->Line(10, 250, 210-10, 250);
            $this->Ln(2);
            $this->SetFont('Arial', '', 8);
           
            $this->tableImportesIvas(array());
            $this->Ln(2);
    
            foreach ($this->content['totalesiva'] as $line) 
            {
                $this->SetTextColor(0,0,0);
                $this->SetFont('Arial', '', 8);
                $this->Cell(20, 5, utf8_decode($line['tipoiva']), '', 0, 'L');
                $this->Cell(20, 5, number_format((float)$line['total_importe'], 2, ',', '.'), '', 0, 'R'); 
                $this->Cell(20, 5, utf8_decode($line['porcentaje']), '', 0, 'R');
                $this->Cell(20, 5, number_format((float)$line['total_iva'], 2, ',', '.'), '', 0, 'R'); 
                $this->Ln(5);
            }
         
 
            $this->Ln(2);
            $this->SetFont('Arial', '', 8);
           
                $this->Cell(140, -38,'', 0, 0, 'L');
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(20, -38,'Importe Bruto:', 0, 0, 'R');
                $this->SetFont('Arial', '', 9);
                $this->Cell(30, -38,number_format((float)$this->content['cabecera']['importebruto'], 2, ',', '.'), 0, 0, 'R');
                
                if($this->content['cabecera']['pordescuento'] > 0){
                    $this->Ln(3);
                    $this->Cell(140, -35,'', 0, 0, 'L');
                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(20, -35,'% Desc:', 0, 0, 'R');
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(30, -35,$this->content['cabecera']['pordescuento'], 0, 0, 'R');
                }
               

                $this->Ln(3);
                $this->Cell(140, -32,'', 0, 0, 'L');
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(20, -32,'Base imponible:', 0, 0, 'R');
                $this->SetFont('Arial', '', 9);
                $this->Cell(30, -32,number_format((float)$this->content['cabecera']['baseimponible'], 2, ',', '.'), 0, 0, 'R');

                $this->Ln(3);
                $this->Cell(140, -29,'', 0, 0, 'L');
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(20, -29,'Total IVA', 0, 0, 'R');
                $this->SetFont('Arial', '', 9);
                $this->Cell(30, -29,number_format((float)$this->content['cabecera']['totaliva'], 2, ',', '.'), 0, 0, 'R');

                
                $this->Ln(3);
                $this->Cell(140, -26,'', 0, 0, 'C');
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(20, -26,'Total Factura (EUR):',0,0,'R');
                $this->SetFont('Arial', '', 9);
                $this->Cell(30, -26,number_format((float)$this->content['cabecera']['importeliquido'], 2, ',', '.'), 0, 0, 'R');

                $this->Ln(3);
                $this->Line(10, 282, 210-10, 282);

          
            
        }else{
            $this->SetY(100); 
            $this->Ln(170);  
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(180, 5, utf8_decode('Suma y sigue...'), 0, 0, 'R');
        }
    }    

         

    /**
     *
     */
    public function bodyTable()
    {
        $height_count = 0;
        $total_margin = [];

        $this->tableHeader(array());
        $this->Ln(8);

       
        foreach ($this->content['lineas'] as $line) {

            // Check if new page was added
            if ($this->multi_pages) {
                $this->tableHeader(array());
                // Reset counters
                $height_count = 0;
                $total_margin = [];
            }
            $this->current_margin = array_sum($total_margin);

            if ($height_count > 0) {
                $this->Ln(5);
            }
           
            $this->SetX(10);
            $this->SetFont('Arial', '', 9);
           
                $this->SetTextColor(0,0,0);
                $this->SetFont('Arial', '', 8);
                $this->Cell(35, 5, utf8_decode($line['codigoarticulo']), '', 0, 'L');
                $this->Cell(70, 5, utf8_decode($this->truncate($line['descripcionarticulo'], 100)), '', 'L');
                $this->Cell(20, 5, ($line['cantidad'] > 0) ? number_format((int)$line['cantidad']):'', '', 0, 'R');
                $this->Cell(28, 5, number_format((float)$line['precioventa'], 2, ',', '.'), '', 0, 'R'); 
                $this->Cell(13, 5, ($line['descuento'] > 0) ? $line['descuento']:'', '', 0, 'R'); 
                $this->Cell(25, 5, ($line['liquidolinea'] > 0) ? number_format((float)$line['liquidolinea'], 2, ',', '.'):'', '', 0, 'R');
            
            // Counters
            $total_margin[] = 5;
            $height_count += 5;

            // Check if margin for multi pages is reached
            if ($this->GetY() > 250) {
                $this->SetTextColor(0,0,0);
                $this->tableClosure();
                $this->footer = false;
                $this->creditocaucion = false;
                $this->AddPage();
                $this->multi_pages = true;
            } else {
                $this->footer = true;
                $this->creditocaucion = true;
                $this->multi_pages = false;
            }

        }

        $this->totalRow();
        $this->tableClosure();

      
    }

    protected function tableHeader(array $lines)
    {
        $this->SetY(80);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 10, utf8_decode($this->referencia), 'TB', 0, 'L');
        $this->Cell(70, 10, utf8_decode($this->descripcion), 'TB', 0, 'L');
        $this->Cell(20, 10, utf8_decode($this->cantidad), 'TB', 0, 'R');
        $this->Cell(28, 10, utf8_decode($this->preciounitario), 'TB', 0, 'R');
        $this->Cell(13, 10, utf8_decode($this->pordescuento), 'TB', 0, 'R');
        $this->Cell(25, 10, utf8_decode($this->totaleuros), 'TB', 0, 'R');
        $this->SetY($this->GetY() + 11);
    }

    protected function blankRow()
    {
        $this->Cell(35, 5, '', '', 0, 'L');
        $this->Cell(70, 5, '', '', 0, 'L');
        $this->Cell(20, 5, '', '', 0, 'R');
        $this->Cell(28, 5, '', '', 0, 'R');
        $this->Cell(13, 5, '', '', 0, 'R');
        $this->Cell(25, 5, '', '', 0, 'R');
        $this->Ln(5);
    }

    protected function tableImportesIvas()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 10, utf8_decode('Tipo IVA'), 'B', 0, 'L');
        $this->Cell(20, 10, utf8_decode('Base Imponible'), 'B', 0, 'L');
        $this->Cell(20, 10, utf8_decode('%IVA'), 'B', 0, 'R');
        $this->Cell(20, 10, utf8_decode('Total IVA'), 'B', 0, 'R');
        $this->Ln(10);
    }

    /**
     * @param string $string
     * @param int $your_desired_width
     * @return string
     */
    protected function truncate(string $string, int $your_desired_width)
    {
        $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
        $parts_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $parts_count; ++$last_part) {
            $length += strlen($parts[$last_part]);
            if ($length > $your_desired_width) {
                break;
            }
        }

        return implode(array_slice($parts, 0, $last_part));
    }

    protected function tableClosure()
    {
        $margin = 115 - $this->current_margin;
        $this->Ln(5);
        $this->Cell(35, $margin, '', '', 0, 'L');
        $this->Cell(70, $margin, '', '', 0, 'L');
        $this->Cell(20, $margin, '', '', 0, 'R');
        $this->Cell(18, $margin, '', '', 0, 'R');
        $this->Cell(13, $margin, '', '', 0, 'R');
        $this->Cell(25, $margin, '', '', 0, 'R');
    }

    protected function totalRow()
    {
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(35, 5, utf8_decode(''), '', 0, 'L');
        $this->Cell(70, 5, utf8_decode(''), '', 0, 'L');
        $this->Cell(20, 5, utf8_decode(''), '', 0, 'R');
        $this->Cell(18, 5, utf8_decode(''), '', 0, 'R');
        $this->Cell(13, 5, utf8_decode(''), '', 0, 'R');
        $this->Cell(25, 5, utf8_decode(''), '', 0, 'R');
    }
}
