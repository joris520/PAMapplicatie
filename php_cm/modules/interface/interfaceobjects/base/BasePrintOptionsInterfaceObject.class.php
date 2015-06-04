<?php

/**
 * Description of BasePrintOptionsInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BasePrintOptionsInterfaceObject extends BaseInterfaceObject
{
    private $detailIndentation;

    protected function __construct( $displayWidth,
                                    $detailIndentation,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->detailIndentation = $detailIndentation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDetailIndentation()
    {
        return $this->getDisplayStyle($this->detailIndentation);
    }

}

?>
