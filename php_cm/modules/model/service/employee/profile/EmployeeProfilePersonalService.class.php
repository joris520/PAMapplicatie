<?php

/**
 * Description of EmployeeProfilePersonalService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');
require_once('modules/model/valueobjects/employee/profile/EmployeeProfilePersonalValueObject.class.php');

// TODO: via service!!
require_once('application/model/service/UserService.class.php');
require_once('application/model/queries/PersonDataQueries.class.php');
require_once('modules/model/service/library/PdpTaskOwnerService.class.php');

class EmployeeProfilePersonalService
{
    const SESSION_STORE_UPLOADED_PHOTO_CONTENTID = 'SESSION_STORE_UPLOADED_PHOTO_CONTENTID';

    static function getValueObject($employeeId)
    {
        $valueObject = NULL;

        $query = EmployeeProfileQueries::selectEmployeeProfilePersonal($employeeId);
        $employeePersonalData = mysql_fetch_assoc($query);
        $valueObject = EmployeeProfilePersonalValueObject::createWithData($employeeId, $employeePersonalData);

        mysql_free_result($query);

        return $valueObject;
    }

    static function validate(   EmployeeProfilePersonalValueObject $valueObject,
                                $isEmailRequired)
    {
        $hasError = false;
        $messages = array();

        $emailAddress = $valueObject->getEmailAddress();
        list($hasError, $messages) = EmailService::validateEmailAddress($emailAddress, $isEmailRequired);

        $firstName = $valueObject->getFirstName();
        if (empty($firstName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_FIRST_NAME');
        }

        $lastName = $valueObject->getLastName();
        if (empty($lastName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_LAST_NAME');
        }

        $gender = $valueObject->getGender();
        if (!EmployeeGenderValue::isValidValue($gender)) {
            $hasError = true;
            $messages[] = TXT_UCF('GENDER_IS_INVALID');
        }

        $birthDate = $valueObject->getBirthDate();
        if (! empty($birthDate)) {
            $checkResult = DateUtils::ValidateDisplayDate(trim($birthDate)); // TODO: validatie error message naar DateUtils!
            if ($checkResult > 0) {
                $hasError = true;
                $error_message = TXT_UCF('DATE_OF_BIRTH');
                switch ($checkResult) {
                    case 1:  $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                        break;
                    case 2:  $error_message .= ': ' . TXT('INVALID_DATE');
                        break;
                    default: $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                }
                $messages[] = $error_message;
            }
        }

        return array($hasError, $messages);
    }

    static function updateValidated($employeeId,
                                    EmployeeProfilePersonalValueObject $valueObject)
    {
        EmployeeProfileQueries::updateProfilePersonal(  $employeeId,
                                                        $valueObject->getFirstName(),
                                                        $valueObject->getLastName(),
                                                        $valueObject->getEmployeeName(),
                                                        $valueObject->getGender(),
                                                        $valueObject->getBirthDate(),
                                                        $valueObject->getBsn(),
                                                        $valueObject->getNationality(),
                                                        $valueObject->getStreet(),
                                                        $valueObject->getPostcode(),
                                                        $valueObject->getCity(),
                                                        $valueObject->getPhoneNumber(),
                                                        $valueObject->getEmailAddress());

    }

    static function updateNameAndEmailRelated(  $employeeId,
                                                EmployeeProfilePersonalValueObject $valueObject)
    {
        $emailAddress   = $valueObject->getEmailAddress();
        $employeeName   = $valueObject->getEmployeeName();
        $firstName      = $valueObject->getFirstName();
        $lastName       = $valueObject->getLastName();

        UserService::updateUserForEmployee($employeeId, $employeeName, $emailAddress);
        PersonDataService::updateForEmployee($employeeId, $firstName, $lastName, $emailAddress);
        PdpTaskOwnerService::updateForEmployee($employeeId, $employeeName);
    }

    static function updateEmailAddressRelated($employeeId, $emailAddress)
    {
        EmployeeProfileQueries::updateEmailAddress($employeeId, $emailAddress);
        UserService::updateUserEmailForEmployee($employeeId, $emailAddress);
        PersonDataService::updateEmailForEmployee($employeeId, $emailAddress);
    }


    static function storeUploadedPhotoContentId($photoContentId)
    {
        $_SESSION[self::SESSION_STORE_UPLOADED_PHOTO_CONTENTID] = $photoContentId;
    }

    static function retrieveUploadedPhotoContentId()
    {
        return @$_SESSION[self::SESSION_STORE_UPLOADED_PHOTO_CONTENTID];
    }

    static function clearUploadedPhotoContentID()
    {
        unset($_SESSION[self::SESSION_STORE_UPLOADED_PHOTO_CONTENTID]);
    }


    static function updatePersonalPhoto($employeeId, $photoFile, $photoContentId)
    {
        EmployeeProfileQueries::updateProfilePersonalPhoto($employeeId, $photoFile, $photoContentId);
    }

    static function clearPersonalPhoto($employeeId)
    {
        EmployeeProfileQueries::removeProfilePersonalPhoto($employeeId);
    }


}

?>
