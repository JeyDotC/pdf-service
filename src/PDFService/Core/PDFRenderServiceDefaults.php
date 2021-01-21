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
final class PDFRenderServiceDefaults
{

    /**
     *
     * @var ITemplatesRepository
     */
    public static $templatesRepository;

    /**
     *
     * @var ITemplateEngine
     */
    public static $templateEngine;

    /**
     *
     * @var IPDFRenderer
     */
    public static $pdfRenderer;

    /**
     *
     * @var IBinStorage
     */
    public static $binStorage;

    public static function __constructStatic()
    {
        self::$templatesRepository = new FileSystemTemplatesRepository(sys_get_temp_dir());
        self::$templateEngine = new RawTemplateEngine(sys_get_temp_dir());
        self::$pdfRenderer = new SnappyPDFRenderer();
        self::$binStorage = new NullBinStorage();
    }
}

PDFRenderServiceDefaults::__constructStatic();
