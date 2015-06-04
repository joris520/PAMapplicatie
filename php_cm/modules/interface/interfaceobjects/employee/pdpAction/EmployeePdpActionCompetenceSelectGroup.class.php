<?php

/**
 * Description of EmployeePdpActionCompetenceSelectGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeePdpActionCompetenceSelectGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionCompetenceSelectGroup.tpl';

    private $contentHeight;

    static function create( $displayWidth,
                            $contentHeight)
    {
        return new EmployeePdpActionCompetenceSelectGroup(  $displayWidth,
                                                            $contentHeight);
    }

    protected function __construct( $displayWidth,
                                    $contentHeight)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->contentHeight = $contentHeight;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeePdpActionCompetenceSelectCategoryGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentHeight()
    {
        return $this->getDisplayStyle($this->contentHeight);
    }

}

?>
