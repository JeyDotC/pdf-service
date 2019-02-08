<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\TemplateEngines;

use PDFService\Core\ITemplateEngine;
use PDFService\Core\Template;

/**
 * Description of TwigTemplateEngine
 *
 * @author jguevara
 */
class TwigTemplateEngine implements ITemplateEngine
{
    //put your code here
    public function renderTemplate(Template $template, $data) {
        $twig = new \Twig_Environment(new \Twig_Loader_Array([
                    $template->getId() => $template->getContents(),
        ]));
        
        return $twig->render($template->getId(), $data);
    }
}
