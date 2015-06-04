<?php


/**
 * Description of EmployeeProfileOrganisationInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/profile/EmployeeProfileOrganisationInterfaceBuilderComponents.class.php');

// interface
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileOrganisationView.class.php');
require_once('modules/interface/interfaceobjects/employee/profile/EmployeeProfileOrganisationEdit.class.php');

// converter
require_once('modules/interface/converter/employee/profile/EmployeeIsBossConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeFteConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeContractStateConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeNameConverter.class.php');


class EmployeeProfileOrganisationInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeProfileOrganisationValueObject $valueObject)
    {
        $interfaceObject = EmployeeProfileOrganisationView::createWithValueObject($valueObject, $displayWidth);

        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('ORGANISATION'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   EmployeeProfileOrganisationInterfaceBuilderComponents::getEditLink($employeeId));

        return $blockInterfaceObject->fetchHtml();

    }

    static function getEditHtml($displayWidth, $employeeId)
    {
        $valueObject = EmployeeProfileOrganisationService::getValueObject($employeeId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_PROFILE_ORGANISATION);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->storeSafeValue('subordinateCount', $valueObject->getBossSubordinateCount());
        $safeFormHandler->addIntegerInputFormatType('department');
        $safeFormHandler->addIntegerInputFormatType('boss');
        $safeFormHandler->addStringInputFormatType('is_boss');
        $safeFormHandler->addStringInputFormatType('phone_number_work');
        $safeFormHandler->addStringInputFormatType('employment_FTE');
        $safeFormHandler->addStringInputFormatType('employment_date');
        $safeFormHandler->addIntegerInputFormatType('contract_state');

        $safeFormHandler->finalizeDataDefinition();

        // interfaceObject
        $interfaceObject = EmployeeProfileOrganisationEdit::createWithValueObject(  $valueObject,
                                                                                    $displayWidth);
        $interfaceObject->setEmploymentDatePicker(  InterfaceBuilderComponents::getCalendarInputPopupHtml(  'employment_date',
                                                                                                            $valueObject->getEmploymentDate()));

        $interfaceObject->setBossIdValues(          EmployeeSelectService::getBossIdValues());
        $interfaceObject->setDepartmentIdValues(    DepartmentService::getDepartmentIdValues());
        // mochten er ondergeschikten zijn maar het vinkje staat niet aan dat dan corrigeren in de interface
        $interfaceObject->setIsBossChecked(         $valueObject->hasSubordinates() || $valueObject->isBoss());

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}

?>
