<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\BinStorages;

use PDFService\Core\IBinStorage;
use PDFService\Core\RenderRequest;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of FileSystemBinStorage
 *
 * @author jguevara
 */
class FileSystemBinStorage implements IBinStorage
{
    private $basePath;
    private $namingStrategy;

    public function __construct($basePath, callable $namingStrategy = null) {
        $this->basePath = $basePath;
        $this->namingStrategy = $namingStrategy ?? function(RenderRequest $request, $pdfBinData){
            return "{$request->getTemplateId()}-" . \md5($pdfBinData) . '-' . \time() . ".pdf";
        };
    }
    
    //put your code here
    public function save(RenderRequest $request, $pdfBinData) {
        $namingStrategy = $this->namingStrategy;
        
        $fileName = $namingStrategy($request, $pdfBinData);
        
        $absolutePathToFileName = implode(DIRECTORY_SEPARATOR, [$this->basePath, $fileName]);
        
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($absolutePathToFileName, $pdfBinData);
        
        return $fileName;
    }

}
