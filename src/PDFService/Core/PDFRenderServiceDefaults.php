<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

use PDFService\BinStorages\NullBinStorage;
use PDFService\PDFRenderers\SnappyPDFRenderer;
use PDFService\TemplateEngines\RawTemplateEngine;
use PDFService\TemplateRepositories\FileSystemTemplatesRepository;

/**
 * Description of PDFRenderServiceDefaults
 *
 * @author jguevara
 */
final class PDFRenderServiceDefaults implements IPDFRendererServiceBuilder
{

    /**
     *
     * @var ITemplatesRepository
     */
    private static $templates;

    /**
     *
     * @var ITemplateEngine
     */
    private static $templateEngine;

    /**
     *
     * @var IPDFRenderer
     */
    private static $pdfRenderer;

    /**
     *
     * @var IBinStorage
     */
    private static $binStorage;

    public static function create() {
        return new static();
    }

    public function __construct() {
        self::$templates = self::$templates ?? new FileSystemTemplatesRepository(sys_get_temp_dir());
        self::$templateEngine = self::$templateEngine ?? new RawTemplateEngine(sys_get_temp_dir());
        self::$pdfRenderer = self::$pdfRenderer ?? new SnappyPDFRenderer();
        self::$binStorage = self::$binStorage ?? new NullBinStorage();
    }

    //put your code here
    public function build(PDFRenderService $service): PDFRenderService {
        return $service->setTemplatesRepository(self::$templates)
                        ->setTemplateEngine(self::$templateEngine)
                        ->setPdfRenderer(self::$pdfRenderer)
                        ->setBinStorage(self::$binStorage);
    }

}
