<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Builders;

use PDFService\BinStorages\FileSystemBinStorage;
use PDFService\Core\IPDFRendererServiceBuilder;
use PDFService\Core\PDFRenderService;
use PDFService\TemplateRepositories\FileSystemTemplatesRepository;

/**
 * Description of FileSystem
 *
 * @author jguevara
 */
class FileSystem implements IPDFRendererServiceBuilder
{

    private $useForBinStorage = false;
    private $binStorageDir;
    private $useForTemplatesRepository = false;
    private $templatesStorageDir;
    private $namingConvention;

    public static function create() {
        return new static();
    }

    public function forBinStorage($dir) {
        $this->useForBinStorage = true;
        $this->binStorageDir = $dir;
        return $this;
    }

    public function forTemplatesStorage($dir, callable $namingConvention = null) {
        $this->useForTemplatesRepository = true;
        $this->templatesStorageDir = $dir;
        $this->namingConvention = $namingConvention;
        return $this;
    }

    //put your code here
    public function build(PDFRenderService $service): PDFRenderService {
        if ($this->useForBinStorage) {
            $fileSystemStorage = $this->namingConvention ? 
                    new FileSystemBinStorage($this->binStorageDir, $this->namingConvention) : 
                    new FileSystemBinStorage($this->binStorageDir);
            
            $service->setBinStorage($fileSystemStorage);
        }

        if ($this->useForTemplatesRepository) {
            $service->setTemplatesRepository(new FileSystemTemplatesRepository($this->templatesStorageDir));
        }
        
        return $service;
    }

}
