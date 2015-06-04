<?php

/**
 * Description of EmployeeTargetBatchInterfaceBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/batch/EmployeeTargetBatchAdd.class.php');
require_once('modules/interface/interfaceobjects/batch/EmployeeTargetBatchAddResult.class.php');

require_once('modules/interface/components/InterfaceBuilderComponents.class.php');

class EmployeeTargetBatchInterfaceBuilder
{
    static function getAddHtml($displayWidth)
    {
        $selectEmployees = new SelectEmployees();

        // safeform
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_BATCH__ADD_TARGET);
        // zelfde namen gebruiken als bij target edit.
        // eigenlijk moeten we hetzelfde template als EditTarget invoegen...
        $safeFormHandler->addStringInputFormatType('target_name');
        $safeFormHandler->addStringInputFormatType('performance_indicator');
        $safeFormHandler->addDateInputFormatType  ('end_date');

        $selectEmployees->fillSafeFormValues($safeFormHandler);

        $safeFormHandler->finalizeDataDefinition();

        // interface
        $interfaceObject = EmployeeTargetBatchAdd::create($displayWidth);
        $interfaceObject->setEndDatePicker(         InterfaceBuilderComponents::getCalendarInputHtml(   'end_date',
                                                                                                        DEFAULT_DATE));
        $interfaceObject->setEmployeesSelectorHtml( InterfaceBuilderComponents::getEmployeesSelectorHtml($selectEmployees));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getConfirmationAddHtml($displayWidth, $targetName, $employeeCount)
    {

        $interfaceObject = EmployeeTargetBatchAddResult::create($displayWidth);
        $interfaceObject->setTargetName(    $targetName);
        $interfaceObject->setEmployeeCount( $employeeCount);

        return $interfaceObject->fetchHtml();
    }
}
?>
