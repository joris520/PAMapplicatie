<?php

/**
 * Description of CustomerInfoValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class CustomerInfoValueObject extends BaseValueObject
{

    private $companyName;
    private $companyEmail;
    private $contactFirstName;
    private $contactLastName;
    private $telephone;
    private $logo;
    private $logosizeWidth;
    private $logosizeHeight;
    private $logoContentId;
    private $maxEmployees;

    // factory methode
    static function createWithData($customerId, $customerInfoData)
    {
        return new CustomerInfoValueObject( $customerId,
                                            $customerInfoData);
    }


    function __construct($customerId, $customerInfoData)
    {
        parent::__construct($customerId,
                            $customerInfoData['saved_by_user_id'],
                            $customerInfoData['saved_by_user'],
                            $customerInfoData['saved_datetime']);

        $this->companyName          = $customerInfoData['company_name'];
        $this->companyEmail         = $customerInfoData['email_address'];
        $this->contactFirstName     = $customerInfoData['firstname'];
        $this->contactLastName      = $customerInfoData['lastname'];
        $this->telephone            = $customerInfoData['telephone'];
        $this->logo                 = $customerInfoData['logo'];
        $this->logosizeWidth        = $customerInfoData['logo_size_width'];
        $this->logosizeHeight       = $customerInfoData['logo_size_height'];
        $this->logoContentId        = $customerInfoData['id_contents'];
        $this->num_employees        = $customerInfoData['num_employees'];

    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $companyName
    function getCompanyName()
    {
        return $this->companyName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $companyEmail
    function getCompanyEmail()
    {
        return $this->companyEmail;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $contactFirstName
    function getContactFirstName()
    {
        return $this->contactFirstName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $contactLastName
    function getContactLastName()
    {
        return $this->contactLastName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $telephone
    function getTelephone()
    {
        return $this->telephone;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $logo
    function getLogoInfo()
    {
        return array($this->logo, $this->logosizeWidth, $this->logosizeHeight, $this->logoContentId);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // maxEmployees
    function getMaxEmployees()
    {
        return $this->maxEmployees;
    }

}

?>
