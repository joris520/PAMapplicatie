<?php

/**
 * Description of EmployeeAnswerHistory
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeAnswerHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAnswerHistory.tpl';

    static function create($displayWidth)
    {
        return new EmployeeAnswerHistory(   $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    // type hinting
    function addValueObject(EmployeeAnswerValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
