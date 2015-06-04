<?php

/**
 * Description of EmployeeListDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeListDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeListDelete.tpl';

    private $confirmQuestion;
    private $removeInfo;


    static function createWithValueObject($valueObject, $displayWidth)
    {
        return new EmployeeListDelete(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setConfirmQuestion($confirmQuestion)
    {
        $this->confirmQuestion = $confirmQuestion;
    }

    function getConfirmQuestion()
    {
        return $this->confirmQuestion;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRemoveInfo($removeInfo)
    {
        $this->removeInfo = $removeInfo;
    }

    function getRemoveInfo()
    {
        return $this->removeInfo;
    }
}

?>
