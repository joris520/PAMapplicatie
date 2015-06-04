<?php

/**
 * Description of DepartmentDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DepartmentDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  DepartmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new DepartmentDelete($valueObject,
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
