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
    
    public static function create()
    {
        $service = new static();
        return $service->using(PDFRenderServiceDefaults::create());
    }

    public function __construct(ITemplatesRepository $templates = null, ITemplateEngine $templateEngine = null, IPDFRenderer $pdfRenderer = null, IBinStorage $storage = null) {
        $this->templates = $templates;
        $this->templateEngine = $templateEngine;
        $this->pdfRenderer = $pdfRenderer;
        $this->binStorage = $storage;
    }

    public function renderPDF(RenderRequest $request) {
        $this->checkSetup();

        $loadedTemplate = $this->templates->loadTemplate($request->getTemplateId());

        $renderedTemplate = $this->templateEngine->renderTemplate($loadedTemplate, $request->getData());

        $pdfData = $this->pdfRenderer->renderPDF($renderedTemplate);

        $pdfHandle = $this->binStorage->save($request, $pdfData);

        return $pdfHandle;
    }
    
    public function using(IPDFRendererServiceBuilder $builder){
        return $builder->build($this);
    }

    private function checkSetup() {
        $this->checkFeature($this->templates, 'Templates repository');
        $this->checkFeature($this->templateEngine, 'Template engine');
        $this->checkFeature($this->pdfRenderer, 'PDF renderer');
        $this->checkFeature($this->binStorage, 'Bin storage');
    }

    private function checkFeature($object, $name) {
        if ($object == null) {
            throw new ConfigurationException("The $name is not setup.");
        }
    }

    public function setTemplatesRepository(ITemplatesRepository $templates) {
        $this->templates = $templates;
        return $this;
    }

    public function setTemplateEngine(ITemplateEngine $templateEngine) {
        $this->templateEngine = $templateEngine;
        return $this;
    }

    public function setPdfRenderer(IPDFRenderer $pdfRenderer) {
        $this->pdfRenderer = $pdfRenderer;
        return $this;
    }

    public function setBinStorage(IBinStorage $binStorage) {
        $this->binStorage = $binStorage;
        return $this;
    }

}
