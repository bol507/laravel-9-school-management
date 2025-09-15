<?php

namespace App\Libraries\PDF;


use Illuminate\Support\Facades\View;
require_once __DIR__ . '/tcpdf/tcpdf.php';

class PDF
{
    protected $html;

    public function loadView(string $view, array $data = [])
    {
        $this->html = View::make($view, $data)->render();
        return $this;
    }

    public function stream(string $filename = 'document.pdf')
    {
        $pdf = new \TCPDF();
        $pdf->SetCreator('MyApp');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->writeHTML($this->html, true, false, true, false, '');
        return $pdf->Output($filename, 'I');
    }

    public function download(string $filename = 'document.pdf')
    {
        $pdf = new \TCPDF();
        $pdf->SetCreator('MyApp');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->writeHTML($this->html, true, false, true, false, '');
        return $pdf->Output($filename, 'D');
    }
}