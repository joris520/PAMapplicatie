<?php

/**
 * Description of EmployeeProfilePersonalInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/profile/EmployeeProfilePersonalInterfaceBuilderComponents.class.php');

// interface
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfilePersonalView.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfilePersonalEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfilePersonalPhotoDelete.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfilePersonalPhotoEdit.class.php');

// values
require_once('modules/model/value/employee/profile/EmployeeGenderValue.class.php');

// converters
require_once('modules/interface/converter/employee/profile/EmployeeGenderConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeNameConverter.class.php');

class EmployeeProfilePersonalInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeProfilePersonalValueObject $valueObject)
    {
        $interfaceObject = EmployeeProfilePersonalView::createWithValueObject(  $valueObject,
                                                                                $displayWidth);
        $interfaceObject->setDeletePhotoLink(   EmployeeProfilePersonalInterfaceBuilderComponents::getDeletePhotoLink(  $employeeId));

        $employeePhoto = new PhotoContent();
        $photoFile = $valueObject->getPhotoFile();
        list($displayablePhoto, $photoWidth, $photoHeight) = $employeePhoto->getEmployeeDisplayablePhoto($photoFile);

        $interfaceObject->setPhoto($displayablePhoto, $photoWidth, $photoHeight);

        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('PERSONAL'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   EmployeeProfilePersonalInterfaceBuilderComponents::getEditLink(         $employeeId));
        $blockInterfaceObject->addActionLink(   EmployeeProfilePersonalInterfaceBuilderComponents::getEditPhotoLink(    $employeeId));

        return $blockInterfaceObject->fetchHtml();
    }

    static function getEditHtml($displayWidth, $employeeId)
    {
        $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
        $userValueObject = UserService::getUserValueObjectForEmployee($employeeId);
        $isEmailRequired = CUSTOMER_OPTION_REQUIRED_EMP_EMAIL ||
                           $userValueObject->hasId() || // als id dan is er een user gekoppeld...
                           AlertsService::hasOpenAlertsAsSender($employeeId);


        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_PROFILE_PERSONAL);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->storeSafeValue('isEmailRequired', $isEmailRequired);
        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->addStringInputFormatType('SN');
        $safeFormHandler->addStringInputFormatType('sex');
        $safeFormHandler->addStringInputFormatType('birth_date'); // vanwege de !readonly een string
        $safeFormHandler->addStringInputFormatType('nationality');
        $safeFormHandler->addStringInputFormatType('street');
        $safeFormHandler->addStringInputFormatType('postal_code');
        $safeFormHandler->addStringInputFormatType('city');
        $safeFormHandler->addStringInputFormatType('phone_number');
        $safeFormHandler->addStringInputFormatType('email_address');

        $safeFormHandler->finalizeDataDefinition();

        // interfaceObjects
        $interfaceObject = EmployeeProfilePersonalEdit::createWithValueObject(  $valueObject,
                                                                                $displayWidth);
        $interfaceObject->setBirthDatePicker(   InterfaceBuilderComponents::getCalendarInputPopupHtml(  'birth_date',
                                                                                                        $valueObject->getBirthDate(),
                                                                                                        '' ,
                                                                                                        false));
        $interfaceObject->setIsEmailRequired(   $isEmailRequired);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml($displayWidth, $employeeId)
    {
        $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__DELETE_PROFILE_PERSONAL_PHOTO);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = EmployeeProfilePersonalPhotoDelete::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setConfirmQuestion(TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_PHOTO'));

        $employeePhoto = new PhotoContent();
        $photoFile = $valueObject->getPhotoFile();
        list($displayablePhoto, $photoWidth, $photoHeight) = $employeePhoto->getEmployeeDisplayablePhoto($photoFile);
        $interfaceObject->setPhoto($displayablePhoto, $photoWidth, $photoHeight);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getUploadHtml(  $displayWidth,
                                    $employeeId)
    {
        $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
        $interfaceObject = EmployeeProfilePersonalPhotoEdit::createWithValueObject( $valueObject,
                                                                                    $displayWidth);

        // via sessie doorgeven aan de upload code
        $_SESSION['ID_E'] = $employeeId;

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_PROFILE_PERSONAL_PHOTO);
        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->finalizeDataDefinition();

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}

?>
