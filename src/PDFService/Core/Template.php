<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PDFService\Core;

/**
 * Description of Template
 *
 * @author jguevara
 */
class Template
{

    private $id;
    private $contents;
    private $lastModified;

    public function __construct($id, $contents, $lastModified) {
        $this->id = $id;
        $this->contents = $contents;
        $this->lastModified = $lastModified;
    }

    public function getId() {
        return $this->id;
    }

    public function getContents() {
        return $this->contents;
    }
    
    public function getLastModified() {
        return $this->lastModified;
    }

}
