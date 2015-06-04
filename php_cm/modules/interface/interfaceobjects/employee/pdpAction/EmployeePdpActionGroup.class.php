<?php

/**
 * Description of EmployeePdpActionGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeePdpActionGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionGroup.tpl';

    private $totalCost;

    static function create( $displayWidth)
    {
        return new EmployeePdpActionGroup(  $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(EmployeePdpActionView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;
    }

    function getTotalCost()
    {
        return $this->totalCost;
    }
}

?>
