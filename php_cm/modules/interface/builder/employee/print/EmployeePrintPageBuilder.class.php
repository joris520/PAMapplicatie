<?php

/**
 * Description of PrintPageBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/print/EmployeePrintInterfaceBuilder.class.php');

class EmployeePrintPageBuilder
{
    static function getPrintOptionsPopupHtml(   $displayWidth,
                                                $contentHeight,
                                                Array $employeeIds,
                                                AssessmentCycleValueObject $assessmentCycleValueObject,
                                                Array /* EmployeeModulePrintOption */ $modulePrintOptions,
                                                Array $selectedPrintOptions)
    {
        list($safeFormHandler, $contentHtml) = EmployeePrintInterfaceBuilder::getPrintOptionsHtml(  $displayWidth,
                                                                                                    $employeeIds,
                                                                                                    $assessmentCycleValueObject,
                                                                                                    $modulePrintOptions,
                                                                                                    $selectedPrintOptions);

        // popup
        $title = TXT_UCF('PRINT_OPTIONS');
        $formId = 'print_options_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getPrintOptionPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }
}

?>
