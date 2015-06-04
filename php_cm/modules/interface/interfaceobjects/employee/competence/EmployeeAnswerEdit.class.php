<?php

/**
 * Description of EmployeeAnswerEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAnswerEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAnswerEdit.tpl';

    private $displayQuestion;

    static function createWithValueObject(  EmployeeAnswerValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAnswerEdit(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDisplayQuestion($displayQuestion)
    {
        $this->displayQuestion = $displayQuestion;
    }

    function getDisplayQuestion()
    {
        return $this->displayQuestion;
    }


}

?>
