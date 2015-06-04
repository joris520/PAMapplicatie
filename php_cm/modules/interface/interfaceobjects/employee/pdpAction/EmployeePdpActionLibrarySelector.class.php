<?php

/**
 * Description of EmployeePdpActionLibrarySelector
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeePdpActionLibrarySelector extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionLibrarySelector.tpl';

    private $interfaceObject;
    private $toggleHtmlId;
    private $contentHtmlId;

    static function create( $displayWidth,
                            $toggleHtmlId,
                            $contentHtmlId)
    {
        return new EmployeePdpActionLibrarySelector($displayWidth,
                                                    $toggleHtmlId,
                                                    $contentHtmlId);
    }

    protected function __construct( $displayWidth,
                                    $toggleHtmlId,
                                    $contentHtmlId)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->toggleHtmlId   = $toggleHtmlId;
        $this->contentHtmlId  = $contentHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getToggleHtmlId()
    {
        return $this->toggleHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentHtmlId()
    {
        return $this->contentHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInterfaceObject(PdpActionSelectGroup $interfaceObject)
    {
        $this->interfaceObject = $interfaceObject;
    }

    function getInterfaceObject()
    {
        return $this->interfaceObject;
    }

}

?>
