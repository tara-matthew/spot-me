<?php

namespace App\Http\Helpers;

use TCPDF;

class Pdf {

    protected $tcpdf;

    public function __construct()
    {
        $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function export($info, $payload) {
        $filteredData=substr($payload, strpos($payload, ",")+1);
        // Need to decode before saving since the data we received is already base64 encoded
        $unencodedData=base64_decode($filteredData);

        $this->tcpdf->setCreator(PDF_CREATOR);
        $this->tcpdf->AddPage();

        $html = '<h1>' . $info['tracks'][0]["name"] . '</h1>
                    <h2>' . $info['tracks'][0]['artist'] . '</h2>';

        $this->tcpdf->writeHTML($html, true, false, true, false, '');
        $this->tcpdf->Image('@'.$unencodedData,'','','','','','','',false,300,'L',false,false,0,'','',false,false);

        $this->tcpdf->Output('C:/Users/taram/Documents/Coding/Laravel/spot-me/example568.pdf', 'F');



    }

}