<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Builders;

use PDFService\Core\IPDFRendererServiceBuilder;
use PDFService\Core\PDFRenderService;
use PDFService\TemplateEngines\TwigTemplateEngine;

/**
 * Description of Twig
 *
 * @author jguevara
 */
class Twig implements IPDFRendererServiceBuilder
{
    public static function create(){
        return new static();
    }

        //put your code here
    public function build(PDFRenderService $service): PDFRenderService {
        return $service->setTemplateEngine(new TwigTemplateEngine());
    }

}
