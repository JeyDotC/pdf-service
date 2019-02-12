<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\BinStorages;

use PDFService\Core\IBinStorage;
use PDFService\Core\RenderRequest;

/**
 * Description of NullBinStorage
 *
 * @author jguevara
 */
class NullBinStorage implements IBinStorage
{

    //put your code here
    public function save(RenderRequest $request, $pdfBinData) {
        return $pdfBinData;
    }
}
