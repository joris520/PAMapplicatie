<?php

/**
 * Description of CustomerService
 *
 * @author ben.dokter
 */

require_once('application/model/queries/CustomerQueries.class.php');
require_once('application/model/valueobjects/CustomerInfoValueObject.class.php');

class CustomerService
{
    static function getInfoValueObject($customerId)
    {
        $query = CustomerQueries::getCompanyInfoByCustomer($customerId);
        $customerInfoData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return CustomerInfoValueObject::createWithData($customerId, $customerInfoData);
    }

    static function isAddEmployeePossible()
    {
        $query = CustomerQueries::getEmployeeCountInfo();
        $employeeCountInfoData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        $maxEmployees = $employeeCountInfoData['max_allowed_employees'];
        $currentEmployees = $employeeCountInfoData['employees_count'];

        $isAddPossible = $currentEmployees < $maxEmployees;
        $employeeHeadroom = max(0, $maxEmployees - $currentEmployees);
        return array($isAddPossible, $employeeHeadroom);
    }


    static function getLogoValueObject($customerId)
    {
        $query = CustomerQueries::getCompanyInfoByCustomer($customerId);
        $customerInfoData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return CustomerInfoValueObject::createWithData($customerId, $customerInfoData);
    }

    static function getCustomerLogoPath($customerId)
    {
        // TODO: zonder ModuleUtils
        return ModuleUtils::getCustomerLogoPath($customerId);
    }

    static function getLogoPath()
    {
        // todo: niet via define...
        return CUSTOMER_LOGO_PATH;
    }

    static function getLogoUrl()
    {
        // todo: niet via define...
        return CUSTOMER_LOGO_URL;
    }

    static function getPhotoPath()
    {
        // todo: niet via define...
        return CUSTOMER_PHOTO_PATH;
    }

}

?>
