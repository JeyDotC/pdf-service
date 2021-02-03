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
 * Description of RawTemplateEngine
 *
 * @author jguevara
 */
class RawTemplateEngine implements ITemplateEngine
{
    private $tempDir;
    
    public function __construct($tempDir = null) {
        $this->tempDir = $tempDir ?? sys_get_temp_dir();
    }

    public function renderTemplate(Template $template, $data) {
        
        $templateFullPath = $this->ensureTemplateContents($template);        
        
        ob_start();
        $callable = require $templateFullPath;
        if(is_callable($callable)){
            $callable($data);
        }
        return ob_get_clean();
    }
    
    private function ensureTemplateContents(Template $template) : string{
        $templateFullPath = implode(DIRECTORY_SEPARATOR, [ $this->tempDir, "{$template->getId()}.php" ]);

        if(is_file($templateFullPath)){
            $info = new \SplFileInfo($templateFullPath);
            if($template->getLastModified()->getTimestamp() > $info->getMTime()){
                file_put_contents($templateFullPath, $template->getContents());
            }
        }else{
            file_put_contents($templateFullPath, $template->getContents());
        }
        
        return $templateFullPath;
    }
}
