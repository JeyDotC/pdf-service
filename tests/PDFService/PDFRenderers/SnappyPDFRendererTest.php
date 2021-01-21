<?php

namespace PDFService\PDFRenderers;

use PHPUnit\Framework\TestCase;

class SnappyPDFRendererTest extends TestCase
{

    public function testHTMLRendersToPDF(){
        // Arrange
        $html = "<html><body><h1>HELLO WORLD!</h1></body></html>";
        $snappyPdfRenderer = new SnappyPDFRenderer(realpath(__DIR__ . '/../../../vendor/bin/wkhtmltopdf' . (PHP_OS_FAMILY === 'Windows' ? '.exe' : '')));

        // Act
        $pdf = $snappyPdfRenderer->renderPDF($html);

        // Assert
        self::assertNotEmpty($pdf, "A PDF content should be generated.");
    }
}
