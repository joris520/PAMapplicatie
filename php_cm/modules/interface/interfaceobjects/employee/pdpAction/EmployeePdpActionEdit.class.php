<?php

/**
 * Description of EmployeePdpActionEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeePdpActionEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionEdit.tpl';

    private $pdpActionLibrarySelector;
    private $todoBeforeDatePicker;
    private $emailAlertDatePicker;



    static function createWithValueObject(  EmployeePdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeePdpActionEdit(   $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

//    protected function __construct( EmployeePdpActionValueObject $valueObject,
//                                    $displayWidth,
//                                    $templateFile)
//    {
//        parent::__construct($valueObject,
//                            $displayWidth,
//                            $templateFile);
//    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPdpActionLibrarySelector( $pdpActionLibrarySelector)
    {
        $this->pdpActionLibrarySelector = $pdpActionLibrarySelector;
    }

    function getPdpActionLibrarySelector()
    {
        return $this->pdpActionLibrarySelector;
    }
}

?>
