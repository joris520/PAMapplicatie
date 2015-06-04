<?php

/**
 * Description of EmployeeProfileInformationValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/BaseEmployeeProfileValueObject.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');

class EmployeeProfileInformationValueObject extends BaseEmployeeProfileValueObject
{
    // information
    private $educationLevel;
    private $additionalInfo;
    private $managerInfo; // hidden_info


    static function createWithData($employeeId, $employeeInformationData)
    {
        return new EmployeeProfileInformationValueObject(   $employeeId,
                                                            $employeeInformationData);
    }

    static function createWithValues(   $employeeId,
                                        $educationLevel,
                                        $additionalInfo,
                                        $managerInfo)
    {
        $employeeInformationData = array();

        $employeeInformationData[EmployeeProfileQueries::ID_FIELD] = $employeeId;
        $employeeInformationData['education_level_fid'] = $educationLevel;
        $employeeInformationData['additional_info']     = $additionalInfo;
        $employeeInformationData['hidden_info']         = $managerInfo;

        return new EmployeeProfileInformationValueObject(   $employeeId,
                                                            $employeeInformationData);
    }

    protected function __construct($employeeId, $employeeInformationData)
    {
        parent::__construct($employeeId,
                            $employeeInformationData);

        $this->educationLevel   = $employeeInformationData['education_level_fid'];
        $this->additionalInfo   = $employeeInformationData['additional_info'];
        $this->managerInfo      = $employeeInformationData['hidden_info'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $educationLevel
    function getEducationLevel()
    {
        return $this->educationLevel;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $additionalInfo
    function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $managerInfo
    function getManagerInfo()
    {
        return $this->managerInfo;
    }

}
?>
