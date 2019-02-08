<?php

namespace PDFService\Core;

/**
 *
 * @author jguevara
 */
interface ITemplatesRepository
{
    public function loadTemplate($templateId) : Template;
}
