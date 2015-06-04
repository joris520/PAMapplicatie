<?php

/**
 * Description of DepartmentCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/organisation/DepartmentValueObject.class.php');

class DepartmentCollection extends BaseCollection
{
    static function create($userId)
    {
        return new DepartmentCollection($userId);
    }

    function addValueObject(DepartmentValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
