<?php

namespace App\Http\Helpers;

use TCPDF;

class Pdf {

    protected $tcpdf;

    public function __construct()
    {
        $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function export($info) {
        $this->tcpdf->setCreator(PDF_CREATOR);
        $this->tcpdf->AddPage();

        $html = '<h1>' . $info[0]["name"] . '</h1>
                    <h2>' . $info[0]['artist'] . '</h2>';

        $this->tcpdf->writeHTML($html, true, false, true, false, '');

        $this->tcpdf->Output('C:/Users/taram/Documents/Coding/Laravel/spot-me/example568.pdf', 'F');



    }

}