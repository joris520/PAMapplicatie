<?php

/**
 * Description of EmployeeProfileService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');
require_once('modules/model/valueobjects/employee/profile/EmployeeProfileCollection.class.php');

require_once('modules/model/service/employee/profile/EmployeeProfilePersonalService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfileOrganisationService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfileInformationService.class.php');
require_once('application/model/service/UserService.class.php');

class EmployeeProfileService
{

    static function getCollection($employeeId)
    {
        $collection = EmployeeProfileCollection::create($employeeId);

        $collection->setPersonalValueObject(        EmployeeProfilePersonalService::getValueObject($employeeId));
        $collection->setPersonalValueObject(        EmployeeProfilePersonalService::getValueObject($employeeId));
        $collection->setOrganisationValueObject(    EmployeeProfileOrganisationService::getValueObject($employeeId));
        $collection->setInformationValueObject(     EmployeeProfileInformationService::getValueObject($employeeId));
        $collection->setJobProfileValueObject(      EmployeeJobProfileService::getValueObject($employeeId));
        $collection->setUserValueObject(            UserService::getUserValueObjectForEmployee($employeeId));

        return $collection;
    }

    static function isRemovable($employeeId)
    {
        return EmployeeSelectService::getBossSubordinateCount($employeeId) == 0;
    }

    static function validateRemove($employeeId)
    {
        $hasError = false;
        $messages = array();

        if (!self::isRemovable($employeeId)) {
            $hasError = true;
            $messages[] = TXT_UCF('YOU_CANNOT_DELETE_THIS_ATTACHMENT_CLUSTER_WHILE_THERE_ARE_ATTACHMENTS_CONNECTED_TO_IT');
        }
        return array($hasError, $messages);
    }

    static function validatePhoto($newPhotoContentId)
    {
        $hasError = false;
        $messages = array();

        if (empty($newPhotoContentId)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_PHOTO_THUMBNAIL');
        }
        return array($hasError, $messages);
    }

    static function archiveEmployee($employeeId)
    {
        if (self::isRemovable($employeeId)) {
            EmployeeProfileQueries::archiveEmployee($employeeId, EMPLOYEE_IS_DISABLED);

//            // clear de geselecteerde medewerker in (sessie) lijst
//            if (ApplicationNavigationService::isSelectedEmployeeId($employeeId)) {
//                ApplicationNavigationService::initializeSelectedEmployeeId( ApplicationNavigationService::CLEAR_SELECTED);
//            }
        }
    }

//    static function reactivateEmployee($employeeId)
//    {
//        return EmployeeProfileQueries::archiveEmployee($employeeId, EMPLOYEE_IS_ACTIVE);
//    }
}

?>
