<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

/**
 *
 * @author jguevara
 */
interface IPDFRendererServiceBuilder
{
    public function build(PDFRenderService $service): PDFRenderService;
}
