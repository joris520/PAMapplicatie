<?php

/**
 * Description of EmployeeProfileOrganisationValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/BaseEmployeeProfileValueObject.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');
require_once('application/model/value/BooleanValue.class.php');

class EmployeeProfileOrganisationValueObject extends BaseEmployeeProfileValueObject
{

    private $bossId;
    private $isBossValue;
    private $departmentId;
    private $phoneNumberWork;
    private $employmentDate; // database date
    private $fte;
    private $employeeNumber;

    private $contractState;

    // afgeleiden apart ophalen
    private $bossEmployeeName;
    private $bossEmailAddress;
    private $bossSubordinateCount;
    //private $bossFirstName;
    //private $bossLastName;
    private $departmentName;


    static function createWithData($employeeId, $employeeOrganisationData)
    {
        return new EmployeeProfileOrganisationValueObject($employeeId,
                                                          $employeeOrganisationData);
    }

    static function createWithValues(   $employeeId,
                                        $bossId,
                                        $isBossValue,
                                        $departmentId,
                                        $phoneNumberWork,
                                        $employmentDate,
                                        $fte,
                                        //$employeeNumber,
                                        $contractState)
    {
        $employeeOrganisationData = array();

        $employeeOrganisationData[EmployeeProfileQueries::ID_FIELD] = $employeeId;
        $employeeOrganisationData['boss_fid']                       = $bossId;
        $employeeOrganisationData['is_boss']                        = $isBossValue == BooleanValue::TRUE ? 1 : 0;
        $employeeOrganisationData['ID_DEPTID']                      = $departmentId;
        $employeeOrganisationData['phone_number_work']              = $phoneNumberWork;
        $employeeOrganisationData['employment_date']                = $employmentDate; // database date
        $employeeOrganisationData['employment_FTE']                 = $fte;
        //$employeeOrganisationData['employee_number']                = $employeeNumber;
        $employeeOrganisationData['contract_state_fid']             = $contractState;

        return new EmployeeProfileOrganisationValueObject($employeeId, $employeeOrganisationData);
    }


    /**
     * constructor
     * @param type $employeeId
     * @param type $mainFunctionId
     * @param type $functionData
     */
    protected function __construct($employeeId, $employeeOrganisationData)
    {
        parent::__construct($employeeId,
                            $employeeOrganisationData);

        // organisation
        $this->bossId           = $employeeOrganisationData['boss_fid'];
        $this->isBossValue      = $employeeOrganisationData['is_boss'] == 1 ? BooleanValue::TRUE : BooleanValue::FALSE;
        $this->departmentId     = $employeeOrganisationData['ID_DEPTID'];
        $this->phoneNumberWork  = $employeeOrganisationData['phone_number_work'];
        $this->employmentDate   = $employeeOrganisationData['employment_date']; // database date
        $this->fte              = $employeeOrganisationData['employment_FTE'];
        $this->employeeNumber   = $employeeOrganisationData['employee_number'];
        $this->contractState    = $employeeOrganisationData['contract_state_fid'];

        $this->bossSubordinateCount   = 0;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bossEmployeeName
    function setBossEmployeeName($bossEmployeeName)
    {
        $this->bossEmployeeName = $bossEmployeeName;
    }

    function getBossEmployeeName()
    {
        return $this->bossEmployeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bossEmailAddress
    function setBossEmailAddress($bossEmailAddress)
    {
        $this->bossEmailAddress = $bossEmailAddress;
    }

    function getBossEmailAddress()
    {
        return $this->bossEmailAddress;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $departmentName
    function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
    }

    function getDepartmentName()
    {
        return $this->departmentName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bossId
    function getBossId()
    {
        return $this->bossId;
    }

    function hasBoss()
    {
        return !empty($this->bossId);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isBossValue
    function getIsBossValue()
    {
        return $this->isBossValue;
    }

    function isBoss()
    {
        return $this->isBossValue == BooleanValue::TRUE;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bossSubordinatesCount
    function setBossSubordinateCount($bossSubordinateCount)
    {
        $this->bossSubordinateCount = $bossSubordinateCount;
    }

    function getBossSubordinateCount()
    {
        return $this->bossSubordinateCount;
    }

    function hasSubordinates()
    {
        return $this->bossSubordinateCount > 0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $departmentId
    function getDepartmentId()
    {
        return $this->departmentId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $phoneNumberWork
    function getPhoneNumberWork()
    {
        return $this->phoneNumberWork;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employmentDate
    function getEmploymentDate()
    {
        return $this->employmentDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $fte
    function getFte()
    {
        return $this->fte;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeNumber
    function getEmployeeNumber()
    {
        return $this->employeeNumber;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $constractState
    function getContractState()
    {
        return $this->contractState;
    }


}

?>