<?php

/**
 * Description of EmployeeProfileCollection
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/BaseCollection.class.php');


require_once('modules/model/valueobjects/employee/profile/EmployeeProfilePersonalValueObject.class.php');
require_once('modules/model/valueobjects/employee/profile/EmployeeProfileOrganisationValueObject.class.php');
require_once('modules/model/valueobjects/employee/profile/EmployeeProfileInformationValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeJobProfileValueObject.class.php');


class EmployeeProfileCollection extends BaseCollection
{
    private $employeeId;
    // de datablokken
    private $personalValueObject;
    private $organisationValueObject;
    private $informationValueObject;
    private $jobProfileValueObject;
    private $userValueObject;

    static function create($employeeId)
    {
        return new EmployeeProfileCollection($employeeId);
    }

    function __construct($employeeId)
    {
        parent::__construct();
        $this->employeeId = $employeeId;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeProfilePersonalValueObject
    function setPersonalValueObject(EmployeeProfilePersonalValueObject $valueObject)
    {
        $this->personalValueObject = $valueObject;
    }

    function getPersonalValueObject()
    {
        return $this->personalValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeProfileOrganisationValueObject
    function setOrganisationValueObject(EmployeeProfileOrganisationValueObject $valueObject)
    {
        $this->organisationValueObject = $valueObject;
    }

    function getOrganisationValueObject()
    {
        return $this->organisationValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeProfileInformationValueObject
    function setInformationValueObject(EmployeeProfileInformationValueObject $valueObject)
    {
        $this->informationValueObject = $valueObject;
    }

    function getInformationValueObject()
    {
        return $this->informationValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeJobProfileValueObject
    function setJobProfileValueObject(EmployeeJobProfileValueObject $valueObject)
    {
        $this->jobProfileValueObject = $valueObject;
    }

    function getJobProfileValueObject()
    {
        return $this->jobProfileValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeUserValueObject
    function setUserValueObject(UserValueObject $valueObject)
    {
        $this->userValueObject = $valueObject;
    }

    function getUserValueObject()
    {
        return $this->userValueObject;
    }


}

?>
