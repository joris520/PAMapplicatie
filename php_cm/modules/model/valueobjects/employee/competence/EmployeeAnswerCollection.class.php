<?php

/**
 * Description of EmployeeAnswerCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class EmployeeAnswerCollection extends BaseCollection
{

    static function create()
    {
        return new EmployeeAnswerCollection();
    }

    function addValueObject(EmployeeAnswerValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
