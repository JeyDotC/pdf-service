<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

/**
 * Description of PDFRenderService
 *
 * @author jguevara
 */
class PDFRenderService
{
    /**
     *
     * @var ITemplatesRepository
     */
    private $templates;
    
    /**
     *
     * @var ITemplateEngine
     */
    private $templateEngine;
    
    /**
     *
     * @var IPDFRenderer
     */
    private $pdfRenderer;
    
    /**
     *
     * @var IBinStorage
     */
    private $binStorage;
    
    public function __construct(ITemplatesRepository $templates, ITemplateEngine $templateEngine, IPDFRenderer $pdfRenderer, IBinStorage $storage) {
        $this->templates = $templates;
        $this->templateEngine = $templateEngine;
        $this->pdfRenderer = $pdfRenderer;
        $this->binStorage = $storage;
    }
    
    public function renderPDF(RenderRequest $request) {
        $loadedTemplate = $this->templates->loadTemplate($request->getTemplateId());
        
        $renderedTemplate = $this->templateEngine->renderTemplate($loadedTemplate, $request->getData());
        
        $pdfData = $this->pdfRenderer->renderPDF($renderedTemplate);
        
        $pdfHandle = $this->binStorage->save($request, $pdfData);
        
        return $pdfHandle;
    }

}
