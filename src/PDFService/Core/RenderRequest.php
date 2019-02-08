<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

/**
 * Description of RenderRequest
 *
 * @author jguevara
 */
class RenderRequest
{
    private $templateId;
    
    private $data;
    
    public function __construct($templateId, $data) {
        $this->templateId = $templateId;
        $this->data = $data;
    }
    
    public function getTemplateId() {
        return $this->templateId;
    }

    public function getData() {
        return $this->data;
    }

    public function setTemplateId($templateId) {
        $this->templateId = $templateId;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }
}
