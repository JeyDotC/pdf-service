<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\PDFRenderers;

use h4cc\WKHTMLToPDF\WKHTMLToPDF;
use Knp\Snappy\Pdf;
use PDFService\Core\IPDFRenderer;

/**
 * Description of SnappyPDFRenderer
 *
 * @author jguevara
 */
class SnappyPDFRenderer implements IPDFRenderer
{

    //put your code here
    public function renderPDF($renderedTemplate) {
        $engine = $this->pickWebkitEngine();
        $snappy = new Pdf($engine);
        $data = $snappy->getOutputFromHtml($renderedTemplate);
        return $data;
    }

    private function pickWebkitEngine(): string {
        $binsPath = __DIR__ . '/../../../../../bin';
        $os = strtoupper(PHP_OS);
        if ($os === 'DARWIN') {
            return "$binsPath/wkhtmltopdf-amd64-osx";
        }
        if ($os === 'WIN') {
            return "$binsPath/wkhtmltopdf64.exe";
        }
        return "$binsPath/wkhtmltopdf-amd64";
    }

}
