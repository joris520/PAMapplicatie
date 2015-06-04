<?php

/**
 * Description of EmployeeInfoValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/BaseEmployeeProfileValueObject.class.php');

class EmployeeInfoValueObject extends BaseEmployeeProfileValueObject
{
    private $emailAddress;
    private $personDataId;
    private $photoFile;

    private $mainFunctionId;
    private $mainFunctionName;
    private $departmentId;
    private $departmentName;
    private $bossId;
    private $bossName;
    private $bossEmailAddress;

    static function createWithData($employeeId, $employeeInfoData)
    {
        return new EmployeeInfoValueObject($employeeId, $employeeInfoData);

    }

    protected function __construct($employeeId, $employeeInfoData)
    {
        parent::__construct($employeeId,
                            $employeeInfoData);

        // personal
        $this->photoFile        = $employeeInfoData['foto_thumbnail'];
        $this->personDataId     = $employeeInfoData['ID_PD'];
        $this->emailAddress     = $employeeInfoData['email_address'];

        // organistation
        $this->mainFunctionId   = $employeeInfoData['ID_F'];
        $this->mainFunctionName = $employeeInfoData['function'];
        $this->departmentId     = $employeeInfoData['ID_DEPT'];
        $this->departmentName   = $employeeInfoData['department'];
        $this->bossId           = $employeeInfoData['boss_fid'];
        $this->bossName         = $employeeInfoData['boss_name'];
        $this->bossEmailAddress = $employeeInfoData['boss_email_address'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPhotoFile()
    {
        return $this->photoFile;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPersonDataId()
    {
        return $this->personDataId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmailAddress()
    {
        return $this->emailAddress;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getMainFunctionId()
    {
        return $this->mainFunctionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getMainFunctionName()
    {
        return $this->mainFunctionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDepartmentId()
    {
        return $this->departmentId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDepartmentName()
    {
        return $this->departmentName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossId()
    {
        return $this->bossId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBssEmailAddress()
    {
        return $this->bossEmailAddress;
    }

}

?>
