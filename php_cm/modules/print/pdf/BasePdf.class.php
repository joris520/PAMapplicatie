<?php

/**
 * Description of BasePdf
 *
 * @author ben.dokter
 */
require_once('pdf/objects/common/printTableBase.inc.php');

class BasePdf
{
    protected $pdfObject;

    protected function __construct(PrintTableBase $pdfObject)
    {
        $this->pdfObject = $pdfObject;
    }
}

?>
