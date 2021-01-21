<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\TemplateRepositories;

use PDFService\Core\Exceptions\TemplateNotFoundException;
use PDFService\Core\ITemplatesRepository;
use PDFService\Core\Template;

/**
 * Description of FileSystemTemplatesRepository
 *
 * @author jguevara
 */
class FileSystemTemplatesRepository implements ITemplatesRepository
{
    private $basePath;

    public function __construct($basePath) {
        $this->basePath = $basePath;
    }

    //put your code here
    public function loadTemplate($templateId) : Template {
        $fullPath = implode(DIRECTORY_SEPARATOR, [$this->basePath, $templateId]);
                
        if(!is_file($fullPath)){
            throw  new TemplateNotFoundException("Template with ID '$templateId' could not be found");
        }

        $file = new \SplFileInfo($fullPath);
        
        return new Template($templateId, file_get_contents($fullPath), $file->getMTime());
    }

}
