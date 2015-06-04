<?php

/**
 * Description of EmployeeProfileUserInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/profile/EmployeeProfileUserInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileUserView.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileUserEdit.class.php');

require_once('application/interface/converter/UserLevelConverter.class.php');

class EmployeeProfileUserInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId,
                                UserValueObject $valueObject)
    {
        $hasUser = $valueObject->hasId();
        $interfaceObject = EmployeeProfileUserView::createWithValueObject(  $valueObject,
                                                                            $displayWidth);
        $interfaceObject->setHasUser($hasUser);

        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('RELATED_USER'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   EmployeeProfileUserInterfaceBuilderComponents::getAddLink(  $employeeId,
                                                                                                            $hasUser));
        return $blockInterfaceObject->fetchHtml();
    }

    static function getAddHtml($displayWidth, $employeeId)
    {
        $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__ADD_PROFILE_USER);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->storeSafeValue('employeeName', $valueObject->getEmployeeName());

        $safeFormHandler->addStringInputFormatType('username');
        $safeFormHandler->addStringInputFormatType('password');
        $safeFormHandler->addStringInputFormatType('email_address');
        $safeFormHandler->addIntegerInputFormatType('user_level');

        $safeFormHandler->finalizeDataDefinition();

        // interfaceObject
        $interfaceObject = EmployeeProfileUserEdit::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setUserLevelMode( UserLevelValue::MODE_EMPLOYEE_EDIT);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
