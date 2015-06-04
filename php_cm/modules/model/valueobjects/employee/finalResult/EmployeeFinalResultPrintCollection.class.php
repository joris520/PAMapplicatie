<?php

/**
 * Description of EmployeeFinalResultPrintCollection
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/finalResult/EmployeeFinalResultValueObject.class.php');

require_once('modules/model/valueobjects/BaseCollection.class.php');

class EmployeeFinalResultPrintCollection extends BaseCollection
{

    static function create()
    {
        return new EmployeeFinalResultPrintCollection();
    }

    function addValueObject(EmployeeFinalResultValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
