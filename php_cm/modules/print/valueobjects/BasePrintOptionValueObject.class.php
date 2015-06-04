<?php

/**
 * Description of BasePrintOptionValueObject
 *
 * @author ben.dokter
 */

class BasePrintOptionValueObject
{
    private $printOptions;

    protected function __construct($printOptions = NULL)
    {
        $this->printOptions = $printOptions;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPrintOptions()
    {
        return $this->printOptions;
    }

}

?>
