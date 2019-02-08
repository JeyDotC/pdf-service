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
interface ITemplateEngine
{
    public function renderTemplate(Template $template, $data);
}
