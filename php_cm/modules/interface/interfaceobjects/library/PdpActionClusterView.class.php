<?php

/**
 * Description of PdpActionClusterView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionClusterView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionClusterView.tpl';

    private $employeeDetailLink;

    static function createWithValueObject(  PdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionClusterView($valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeDetailLink($employeeDetailLink)
    {
        $this->employeeDetailLink = $employeeDetailLink;
    }

    function getEmployeeDetailLink()
    {
        return $this->employeeDetailLink;
    }

}

?>
