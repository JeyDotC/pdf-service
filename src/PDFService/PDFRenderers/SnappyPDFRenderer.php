<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\PDFRenderers;

use Knp\Snappy\Pdf;
use PDFService\Core\IPDFRenderer;

/**
 * Description of SnappyPDFRenderer
 *
 * @author jguevara
 */
class SnappyPDFRenderer implements IPDFRenderer
{
    private $runtimePath = "";

    /**
     * SnappyPDFRenderer constructor.
     * @param string|null $runtimePath
     */
    public function __construct(string $runtimePath = null)
    {
        $this->runtimePath = $runtimePath ?? __DIR__ . '/../../../../../bin/wkhtmltopdf' . (PHP_OS_FAMILY === 'Windows' ? '.exe' : '');
    }

    public function renderPDF($renderedTemplate) {
        $snappy = new Pdf($this->runtimePath);
        $data = $snappy->getOutputFromHtml($renderedTemplate);
        return $data;
    }

}
