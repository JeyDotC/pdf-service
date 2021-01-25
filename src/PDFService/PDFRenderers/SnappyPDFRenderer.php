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

    private $runUnderXVirtualFrameBuffer = false;

    /**
     * SnappyPDFRenderer constructor.
     * @param string|null $runtimePath The absolute path to the `wkhtmltopdf` binary. If not provided, it will attempt to use the one under the ./vendor/bin folder.
     * @param bool $useXvfb For some systems (usually Linux Servers) we need to use XVFB in order to work.
     */
    public function __construct(string $runtimePath = null, $useXvfb = false)
    {
        $this->runtimePath = $runtimePath ?? __DIR__ . '/../../../../../bin/wkhtmltopdf' . (PHP_OS_FAMILY === 'Windows' ? '.exe' : '');
        $this->runUnderXVirtualFrameBuffer = $useXvfb;
    }

    /**
     * @param $renderedTemplate
     * @return mixed
     * @throws \Exception
     */
    public function renderPDF($renderedTemplate) {
        if(!is_file($this->runtimePath)){
            throw new \Exception("The runtimePath for the PDF renderer is not properly configured.");
        }

        $command = $this->runUnderXVirtualFrameBuffer ? "xvfb-run {$this->runtimePath}" : $this->runtimePath;

        $snappy = new Pdf($command);
        $data = $snappy->getOutputFromHtml($renderedTemplate);
        return $data;
    }

}
