<?php

namespace App\Http\Helpers;

use TCPDF;

class Pdf
{

    protected $tcpdf;

    public function __construct()
    {
        $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function export($info)
    {
        $this->tcpdf->setCreator(PDF_CREATOR);
        $this->tcpdf->setPrintHeader(false);
        $this->tcpdf->setPrintFooter(false);
        $this->tcpdf->AddPage();

        $html = '<h1 class="margin" style="text-align:center;">' . $info['info']['playlistTitle'] . '</h1> <br>';

        $this->tcpdf->writeHTML($html, true, false, true, false, '');

        foreach ($info['tracks'] as $key => $tracks) {

            $filteredData = substr($tracks['image'], strpos($tracks['image'], ",") + 1);
            $unencodedData = base64_decode($filteredData);


            $html = '
                <div class="center">
                    <p>' . $tracks["name"] . '</p>
                    <p>' . $tracks['artist'] . '</p>
                </div>
                <br>
            ';

            $this->tcpdf->Image('@' . $unencodedData,
                '',
                '',
                '35',
                '35',
                '',
                '',
                '',
                false,
                300,
                'R',
                false,
                false,
                0,
                '',
                '',
                false,
                false);

            $this->tcpdf->writeHTML($html, true, false, true, false, '');

        }

        $this->tcpdf->Output('C:/Users/taram/Documents/Coding/Laravel/spot-me/exports/' . $info['info']['playlistTitle'] . '.pdf', 'D');

    }

}