<?php

/**
 * Description of EmployeeProfileInformationInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/profile/EmployeeProfileInformationInterfaceBuilderComponents.class.php');

require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileInformationView.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileInformationEdit.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeEducationLevelConverter.class.php');

class EmployeeProfileInformationInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeProfileInformationValueObject $valueObject)
    {
        $interfaceObject = EmployeeProfileInformationView::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setIsAllowedShowManagerInfo(  PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS));


        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   EmployeeProfileInformationInterfaceBuilderComponents::getEditLink($employeeId));

        return $blockInterfaceObject->fetchHtml();

    }

    static function getEditHtml($displayWidth, $employeeId)
    {
        $valueObject = EmployeeProfileInformationService::getValueObject($employeeId);
        $isEditAllowedManagerInfo = PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_PROFILE_INFORMATION);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->storeSafeValue('isEditAllowedManagerInfo', $isEditAllowedManagerInfo);
        $safeFormHandler->addIntegerInputFormatType('education_level');
        $safeFormHandler->addStringInputFormatType('additional_info');
        $safeFormHandler->addStringInputFormatType('manager_info');
        $safeFormHandler->finalizeDataDefinition();

        // interfaceobjcet
        $interfaceObject = EmployeeProfileInformationEdit::createWithValueObject(   $valueObject,
                                                                                    $displayWidth);
        $interfaceObject->setIsEditAllowedManagerInfo( $isEditAllowedManagerInfo);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
