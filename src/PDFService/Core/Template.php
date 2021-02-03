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
    /**
     * @var \DateTime
     */
    private $lastModified;

    public function __construct($id, $contents, \DateTime $lastModified)
    {
        $this->id = $id;
        $this->contents = $contents;
        $this->lastModified = $lastModified;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

}
