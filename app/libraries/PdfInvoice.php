<?php 

namespace App\libraries;

//use App\Http\Controllers\QrCodeController;
use Fpdf;

class PdfInvoice extends Fpdf
{
    protected $content;
    protected $multi_pages = false;
    const MAX_ROWS = 100;
    const InitialY = 75;
    protected $total_import;
    protected $current_margin;
    protected $total_iva = [0 => [], 1 => [], 2 => []];
    protected $footer;

    /**
     * Load Data to render invoice
     * @param array $invoice_content
     */
    public function LoadData(array $invoice_content)
    {
      
        $this->content = $invoice_content;
        //$this->SetY(75);
        //$this->SetX(15);
        //$this->SetFont('Arial', 'B', 8);
    }

    /**
     * Page Header
     */
    function Header()
    {
        //$this->Image(public_path() . '/img/logo_lsh_291x412.png', 25, 10, 40, 30);
        $this->SetFont('Arial', 'B', '10');
        $this->Cell(100);
        // Título
        $this->Cell(40, 5, 'Periodo', 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Factura Nº'), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Página'), 1, 0, 'C');
        // Salto de línea
        $this->Ln(5);
        $this->Cell(100);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, $this->content['proveedor']['FechaFactura'], 1, 0, 'C');
        //$this->Cell(25, 5, $this->content['number'], 1, 0, 'C');
        $this->Cell(25, 5, $this->PageNo() . '/{nb}', 1, 0, 'C');

        $this->Ln(15);
        $this->SetFont('Arial', '', 10);
        $this->Text($this->GetX() + 5, $this->GetY() - 1, 'PROVEEDOR');
        $this->Text($this->GetX() + 115, $this->GetY() - 1, 'CLIENTE');
        $this->SetFont('Arial', 'B', 8);
        $this->clientAddress();
        $this->SetFont('Arial', 'B', 8);

        $this->Ln(-25);
        $this->Cell(110);
        $this->FuturenerAddress();

    }

    /**
     * Page Footer
     */
    function Footer()
    {
        if ($this->footer) {
            $this->SetY(-45);
            $this->Cell(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('BASE IMPONIBLE'), 1, 0, 'C');
            $this->Cell(10, 5, utf8_decode('IVA'), 1, 0, 'C');
            $this->Cell(30, 5, utf8_decode('TOTAL IVA'), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(30, 5,
                number_format(array_sum($this->total_iva[1]), 2, ',', '.'), 1, 0, 'C');
            $this->Cell(10, 5,
                utf8_decode($this->content['proveedor']['IVA'] . '%'), 1, 0, 'C');
            $iva_group_1 = array_sum($this->total_iva[1]) * $this->content['proveedor']['IVA'] / 100;
            $this->Cell(30, 5,
                number_format($iva_group_1, 2, ',', '.'), 1, 0, 'C');

//            $this->Ln(10);
//            $this->Cell(5);
//            $this->SetFont('Arial', 'B', 8);
//            $this->Cell(20, 5, utf8_decode('IMPORTE'), 1, 0, 'C');
//
//            $this->SetFont('Arial', '', 8);
//
//            $this->Ln(5);
//            $this->Cell(5);
//            $this->Cell(20, 5,
//                number_format($iva_group_1 + $this->total_import, 2, ',', '.'), 1, 0, 'C');

            $this->Ln(-5);
//            $this->Cell(129);
//            $this->Cell(30, 5, 'IMPORTE BRUTO', 'LT', 0, 'L');
//            $this->Cell(30, 5, utf8_decode(
//                number_format($this->total_import, 2, ',', '.')), 'TR', 0, 'C');
//            $this->Ln(5);
            $this->Cell(129);
            $this->Cell(30, 5, 'BASE IMPONIBLE', 'LT', 0, 'L');
            $this->Cell(30, 5,
                number_format($this->total_import, 2, ',', '.'), 'RT', 0, 'C');
            /*if ($this->content['proveedor']['IRPF'] != 0) {
                $this->Ln(5);
                $this->Cell(129);
                $this->Cell(30, 5, '- ' . $this->content['proveedor']['IRPF'] . '% IRPF', 'L', 0, 'L');
                $this->Cell(30, 5,number_format($this->total_import * $this->content['proveedor']['IRPF'] / 100, 2, ',', '.'), 'R', 0, 'C');
            }*/
            /*$this->Cell(30, 5,
                utf8_decode(number_format($this->total_import -
                    ($this->total_import * $this->content['proveedor']['IRPF'] / 100), 2, ',', '.')),
                'R', 0, 'C');*/
            $this->Ln(5);
            $this->Cell(129);
            $this->Cell(30, 5, 'TOTAL I.V.A.', 'L', 0, 'L');
            $this->Cell(30, 5, number_format($iva_group_1, 2, ',', '.'), 'R', 0, 'C');
            $this->SetFont('Arial', 'B', 8);
            $this->Ln(5);
            $this->Cell(129);
            $this->Cell(30, 5, 'TOTAL FACTURA EUROS', 'LTB', 0, 'L');
//            $this->Cell(30, 5,
//                number_format($iva_group_1 + $this->total_import, 2, ',', '.'), 'TRB', 0, 'C');
            //$this->Cell(30, 5,number_format($iva_group_1 + $this->total_import-($this->total_import * $this->content['proveedor']['IRPF'] / 100), 2, ',', '.'),'TRB', 0, 'C');

            $this->Ln(5);
            $this->Cell(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, '', 0, 0, 'L');
        } else {
            $this->SetFont('Arial', 'B', 14);
            $this->SetXY(150, -20);
            $this->Cell(200, 5, 'Suma y sigue...');
            $this->SetXY(20, -50);
            // $this->FuturenerAddress();
        }
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

    /**
     * Body
     */
    public function bodyTable()
    {

        $height_count = 0;
        $total_margin = [];

        $this->tableHeader(array());

        
    }

    protected function blankRow()
    {
        $this->Cell(20, 5, '', 'LR', 0, 'C');
        $this->Cell(100, 5, '', 'LR', 0, 'C');
        $this->Cell(15, 5, '', 'LR', 0, 'C');
        $this->Cell(15, 5, '', 'LR', 0, 'C');
        $this->Cell(10, 5, '', 'LR', 0, 'C');
        $this->Cell(12, 5, '', 'LR', 0, 'C');
        $this->Cell(20, 5, '', 'LR', 0, 'C');
        $this->Ln(5);
    }

    protected function tableClosure()
    {
        $margin = 115 - $this->current_margin;
        $this->Cell(170, $margin, '', 'LRB', 0, 'C');
        $this->Cell(20, $margin, '', 'LRB', 0, 'C');
        $this->Cell(20, $margin, '', 'LRB', 0, 'C');
    }

    protected function tableHeader(array $lines)
    {
        $this->SetY(65);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(170, 5, utf8_decode('Descripción'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('Importe EUR'), 1, 0, 'C');
        $this->SetY($this->GetY() + 5);
    }

    protected function totalRow()
    {
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode(''), 'LR', 0, 'C');
        $this->Cell(100, 5, utf8_decode('TOTAL'), 'LR', 0, 'L');
        $this->Cell(15, 5, utf8_decode(''), 'LR', 0, 'C');
        $this->Cell(15, 5, utf8_decode(''), 'LR', 0, 'C');
        $this->Cell(10, 5, utf8_decode(''), 'LR', 0, 'C');
        $this->Cell(12, 5, utf8_decode(''), 'LR', 0, 'C');
        $this->Cell(20, 5, utf8_decode(number_format($this->total_import +
            array_sum($this->total_iva[1]) * $this->content['proveedor']['IVA'] / 100, 2, ',', '.')),
            'LR', 0, 'C');

    }

    protected function FuturenerAddress()
    {
        $this->MultiCell(73, 5,
            utf8_decode(
                'Futurener Consultora S.L.' . "\n" .
                'B-86153947' . "\n" .
                'C/ esperanza macarena 21 A' . "\n" .
                '28021 - Madrid - España' . "\n" .
                'TELF: 91 772 99 06' . "\n"
            ), 1, 'L', false);
    }

    protected function clientAddress()
    {
        $this->MultiCell(70, 5,
            utf8_decode(
                $this->content['proveedor']['RazonSocial'] . "\n" .
                $this->content['proveedor']['Domicilio'] . "\n" .
                'CIF: ' . $this->content['proveedor']['CifDni']
            ), 1, 'L', false);
    }
}
