<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\TemplateEngines;

use PDFService\Core\ITemplateEngine;
use PDFService\Core\Template;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of RawTemplateEngine
 *
 * @author jguevara
 */
class RawTemplateEngine implements ITemplateEngine
{
    private $tempDir;
    
    public function __construct($tempDir) {
        $this->tempDir = $tempDir;
    }

        //put your code here
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
        $fileSystem = new Filesystem();
        
        if($fileSystem->exists($templateFullPath)){
            $info = new \SplFileInfo($templateFullPath);
            if($template->getLastModified() > $info->getMTime()){
                $fileSystem->dumpFile($templateFullPath, $template->getContents());
            }
        }else{
           $fileSystem->dumpFile($templateFullPath, $template->getContents()); 
        }
        
        return $templateFullPath;
    }
}
