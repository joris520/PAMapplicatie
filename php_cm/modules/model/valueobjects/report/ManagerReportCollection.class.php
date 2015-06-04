<?php

/**
 * Description of ManagerReportCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/report/ManagerReportValueObject.class.php');

class ManagerReportCollection extends BaseCollection
{
    static function create()
    {
        return new ManagerReportCollection();
    }

    function addValueObject(ManagerReportValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
