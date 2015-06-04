<?php

/**
 * Description of ManagerReportValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class ManagerReportValueObject extends BaseReportValueObject
{
    private $subordinatesCount;
    private $managerName;
    private $managerUserValueObject;

    static function createWithData($managerReportData)
    {
        return new ManagerReportValueObject($managerReportData[ManagerReportQueries::ID_FIELD], $managerReportData);
    }

    protected function __construct($managerReportId, $managerReportData)
    {
        parent::__construct($managerReportId);

        $this->managerName          = EmployeeNameConverter::displaySortable($managerReportData['firstname'], $managerReportData['lastname']);
        $this->subordinatesCount    = $managerReportData['subordinate_count'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getSubordinatesCount()
    {
        return $this->subordinatesCount;
    }

    function hasSubordinates()
    {
        return ($this->subordinatesCount > 0);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getManagerName()
    {
        return $this->managerName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function setManagerUserValueObject(UserValueObject $managerUserValueObject)
    {
        $this->managerUserValueObject = $managerUserValueObject;
    }

    /**
     *
     * @return UserValueObject
     */
    function getManagerUserValueObject()
    {
        return $this->managerUserValueObject;
    }
}

?>
