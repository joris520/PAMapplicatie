<?php

/**
 * Description of BasePrintOptionDetailInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BasePrintOptionsInterfaceObject.class.php');

class BasePrintOptionDetailInterfaceObject extends BasePrintOptionsInterfaceObject
{
    private $isInitialVisible;
    private $printOption;


    protected function __construct( $displayWidth,
                                    $printOption,
                                    $detailIndentation,
                                    $isInitialVisible,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $detailIndentation,
                            $templateFile);

        $this->printOption = $printOption;
        $this->isInitialVisible = $isInitialVisible;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isInitialVisible()
    {
        return $this->isInitialVisible;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPrintOption()
    {
        return $this->printOption;
    }

}

?>
