<?php

/**
 * Description of EmployeeJobProfileHistory
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeJobProfileHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeJobProfileHistory.tpl';

    static function create($displayWidth)
    {
        return new EmployeeJobProfileHistory(   $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    // type hinting
    function addValueObject(EmployeeJobProfileValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
