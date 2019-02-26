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
    private $namingStrategy;

    public static function create() {
        return new static();
    }

    public function forBinStorage($dir, callable $namingStrategy = null) {
        $this->useForBinStorage = true;
        $this->binStorageDir = $dir;
        $this->namingStrategy = $namingStrategy;
        return $this;
    }

    public function forTemplatesStorage($dir) {
        $this->useForTemplatesRepository = true;
        $this->templatesStorageDir = $dir;
        return $this;
    }

    //put your code here
    public function build(PDFRenderService $service): PDFRenderService {
        if ($this->useForBinStorage) {
            $fileSystemStorage = $this->namingStrategy ? 
                    new FileSystemBinStorage($this->binStorageDir, $this->namingStrategy) : 
                    new FileSystemBinStorage($this->binStorageDir);
            
            $service->setBinStorage($fileSystemStorage);
        }

        if ($this->useForTemplatesRepository) {
            $service->setTemplatesRepository(new FileSystemTemplatesRepository($this->templatesStorageDir));
        }
        
        return $service;
    }

}
