<?php

/**
 * Description of TalentSelectorResultCollection
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/BaseCollection.class.php');

require_once('modules/model/valueobjects/report/TalentSelectorResultValueObject.class.php');


class TalentSelectorResultCollection extends BaseCollection
{
    private $resultObjects;
    private $employeesMatchCount;
    private $hasMatches;
    private $requestedCount;

    static function create($requestedCount)
    {
        return new TalentSelectorResultCollection($requestedCount);
    }

    protected function __construct($requestedCount)
    {
        parent::__construct();
        $this->resultObjects = array();
        $this->employeesMatchCount = array();
        $this->hasMatches = false;
        $this->requestedCount = $requestedCount;

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addMatchForEmployee($employeeId)
    {
        $this->employeesMatchCount[$employeeId] += 1;
    }

    function addResultObject(TalentSelectorResultValueObject $resultObject)
    {
        $this->resultObjects[] = $resultObject;

        if ($resultObject->hasScoreObjects()) {
            $this->hasMatches = true;
        }
    }

    function getResultObjects()
    {
        return $this->resultObjects;
    }

    function hasMatches()
    {
        return $this->hasMatches;
    }

    function getEmployeesMatchCount()
    {
        return $this->employeesMatchCount;
    }

    function getRequestedCount()
    {
        return $this->requestedCount;
    }
}

?>
