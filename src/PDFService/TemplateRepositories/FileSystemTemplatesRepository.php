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
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
        $finder = Finder::create()
                ->files()
                ->in($this->basePath)
                ->name($templateId);
                
        if(!$finder->hasResults()){
            throw  new TemplateNotFoundException("Template with ID '$templateId' could not be found");
        }
        
        $iterator = $finder->getIterator();
        $iterator->rewind();
        /** @var SplFileInfo $file */
        $file = $iterator->current();
        
        return new Template($templateId, $file->getContents(), $file->getMTime());
    }

}
