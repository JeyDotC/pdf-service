<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

use PDFService\Core\Exceptions\ConfigurationException;

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
        return new static(
            PDFRenderServiceDefaults::$templatesRepository,
            PDFRenderServiceDefaults::$templateEngine,
            PDFRenderServiceDefaults::$pdfRenderer,
            PDFRenderServiceDefaults::$binStorage
        );
    }

    public function __construct(ITemplatesRepository $templatesRepository = null, ITemplateEngine $templateEngine = null, IPDFRenderer $pdfRenderer = null, IBinStorage $binStorage = null) {
        $this->templates = $templatesRepository;
        $this->templateEngine = $templateEngine;
        $this->pdfRenderer = $pdfRenderer;
        $this->binStorage = $binStorage;
    }

    /**
     * @param RenderRequest $request
     * @return mixed
     * @throws ConfigurationException
     */
    public function renderPDF(RenderRequest $request) {
        $this->checkSetup();

        $loadedTemplate = $this->templates->loadTemplate($request->getTemplateId());

        $renderedTemplate = $this->templateEngine->renderTemplate($loadedTemplate, $request->getData());

        $pdfData = $this->pdfRenderer->renderPDF($renderedTemplate);

        $pdfHandle = $this->binStorage->save($request, $pdfData);

        return $pdfHandle;
    }

    /**
     * @throws ConfigurationException
     */
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

    public function setTemplatesRepository(ITemplatesRepository $templates): PDFRenderService
    {
        $this->templates = $templates;
        return $this;
    }

    public function setTemplateEngine(ITemplateEngine $templateEngine): PDFRenderService
    {
        $this->templateEngine = $templateEngine;
        return $this;
    }

    public function setPdfRenderer(IPDFRenderer $pdfRenderer): PDFRenderService
    {
        $this->pdfRenderer = $pdfRenderer;
        return $this;
    }

    public function setBinStorage(IBinStorage $binStorage): PDFRenderService
    {
        $this->binStorage = $binStorage;
        return $this;
    }

}
