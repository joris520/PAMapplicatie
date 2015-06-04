<?php

/**
 * Description of EmployeePdpActionDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeePdpActionDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  EmployeePdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeePdpActionDelete( $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setConfirmQuestion($confirmQuestion)
    {
        $this->confirmQuestion = $confirmQuestion;
    }

    function getConfirmQuestion()
    {
        return $this->confirmQuestion;
    }

}

?>
