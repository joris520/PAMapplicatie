<?php
/**
 * Description of EmployeePdpActionUserDefinedEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');
require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionUserDefinedValueObject.class.php');

class EmployeePdpActionUserDefinedEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionUserDefinedEdit.tpl';

    private $dateWarning;
    private $pdpActionLibrarySelector;

    static function createWithValueObject(  EmployeePdpActionUserDefinedValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeePdpActionUserDefinedEdit($valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDateWarning($dateWarning)
    {
        $this->dateWarning = $dateWarning;
    }

    function hasDateWarning()
    {
        return $this->dateWarning;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPdpActionLibrarySelector($pdpActionLibrarySelector)
    {
        $this->pdpActionLibrarySelector = $pdpActionLibrarySelector;
    }

    function getPdpActionLibrarySelector()
    {
        return $this->pdpActionLibrarySelector;
    }

}

?>
