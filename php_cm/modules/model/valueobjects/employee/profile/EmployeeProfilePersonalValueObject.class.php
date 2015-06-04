<?php

/**
 * Description of EmployeeProfilePersonalValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/profile/BaseEmployeeProfileValueObject.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');

class EmployeeProfilePersonalValueObject extends BaseEmployeeProfileValueObject
{
    // personal
    private $gender;
    private $birthDate;  // database date
    private $bsn;
    private $nationality;

    // contact
    private $street;
    private $postcode;
    private $city;
    private $phoneNumber;
    private $emailAddress;

    // system
    //private $isActive;
    private $personDataId;
    private $photoFile;
    private $photoContentId;
    private $externalSystemIdentifier;


    static function createWithData($employeeId, $employeePersonalData)
    {
        return new EmployeeProfilePersonalValueObject($employeeId, $employeePersonalData);
    }

    static function createWithValues(   $employeeId,
                                        $firstName,
                                        $lastName,
                                        $employeeName,
                                        $gender,
                                        $birthDate,
                                        $bsn,
                                        $nationality,
                                        $street,
                                        $postcode,
                                        $city,
                                        $phoneNumber,
                                        $emailAddress)
    {
        $employeePersonalData = array();

        $employeePersonalData[EmployeeProfileQueries::ID_FIELD] = $employeeId;

        // personal
        $employeePersonalData['firstname']              = $firstName;
        $employeePersonalData['lastname']               = $lastName;
        $employeePersonalData['employee']               = $employeeName;
        $employeePersonalData['sex']                    = $gender;
        $employeePersonalData['birthdate']              = $birthDate;  // database date
        $employeePersonalData['SN']                     = $bsn;
        $employeePersonalData['nationality']            = $nationality;

        // contact
        $employeePersonalData['address']                = $street;
        $employeePersonalData['postal_code']            = $postcode;
        $employeePersonalData['city']                   = $city;
        $employeePersonalData['phone_number']           = $phoneNumber;
        $employeePersonalData['email_address']          = $emailAddress;

        return new EmployeeProfilePersonalValueObject($employeeId, $employeePersonalData, false);
    }


    /**
     * constructor
     * @param type $employeeId
     * @param type $mainFunctionId
     * @param type $functionData
     */
    protected function __construct($employeeId, $employeePersonalData, $fromDatabase = true)
    {
        parent::__construct($employeeId,
                            $employeePersonalData);

        // personal
        $this->gender           = $employeePersonalData['sex'];
        $this->birthDate        = $employeePersonalData['birthdate'];  // database date
        $this->bsn              = $employeePersonalData['SN'];
        $this->nationality      = $employeePersonalData['nationality'];

        // contact
        $this->street           = $employeePersonalData['address'];
        $this->postcode         = $employeePersonalData['postal_code'];
        $this->city             = $employeePersonalData['city'];
        $this->phoneNumber      = $employeePersonalData['phone_number'];
        $this->emailAddress     = $employeePersonalData['email_address'];

        // system
        if ($fromDatabase) {
            //$this->isActive                 = $employeePersonalData['is_inactive'] == EMPLOYEE_IS_ACTIVE;
            $this->personDataId             = $employeePersonalData['ID_PD'];
            $this->photoFile                = $employeePersonalData['foto_thumbnail'];
            $this->photoContentId           = $employeePersonalData['id_contents'];
            $this->externalSystemIdentifier = $employeePersonalData['external_system_identifier'];
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $gender
    function getGender()
    {
        return $this->gender;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $birthDate
    function getBirthDate()
    {
        return $this->birthDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bsn
    function getBsn()
    {
        return $this->bsn;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $nationality
    function getNationality()
    {
        return $this->nationality;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $street
    function getStreet()
    {
        return $this->street;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $postalCode
    function getPostcode()
    {
        return $this->postcode;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $city
    function getCity()
    {
        return $this->city;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $phoneNumber
    function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $emailAdress
    function getEmailAddress()
    {
        return $this->emailAddress;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $personDataId
    function getPersonDataId()
    {
        return $this->personDataId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $photoFile
    function getPhotoFile()
    {
        return $this->photoFile;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $photoContentId
    function getPhotoContentId()
    {
        return $this->photoContentId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $externalSystemIdentifier
    function getExternalSystemIdentifier()
    {
        return $this->externalSystemIdentifier;
    }
}

?>
