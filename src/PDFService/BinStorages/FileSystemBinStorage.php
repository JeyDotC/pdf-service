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

    public function __construct($basePath) {
        $this->basePath = $basePath;
    }
    
    //put your code here
    public function save(RenderRequest $request, $pdfBinData) {
        
        $fileName = \sha1(time()) . '.pdf';
        
        $absolutePathToFileName = implode(DIRECTORY_SEPARATOR, [$this->basePath, $fileName]);
                
        
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($absolutePathToFileName, $pdfBinData);
        
        return $fileName;
    }

}
