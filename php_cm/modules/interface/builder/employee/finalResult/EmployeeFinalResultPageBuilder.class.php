<?php

/**
 * Description of EmployeeFinalResultPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/finalResult/EmployeeFinalResultInterfaceBuilder.class.php');

class EmployeeFinalResultPageBuilder
{
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject,
                                EmployeeFinalResultValueObject $valueObject,
                                EmployeeFinalResultValueObject $previousValueObject)
    {

        return  EmployeeFinalResultInterfaceBuilder::getEmployeeInfoHeaderHtml( $displayWidth,
                                                                                $employeeId,
                                                                                $employeeInfoValueObject) .
                EmployeeFinalResultInterfaceBuilder::getViewHtml(   $displayWidth,
                                                                    $employeeId,
                                                                    $valueObject,
                                                                    $previousValueObject);
    }

    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        EmployeeFinalResultValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = EmployeeFinalResultInterfaceBuilder::getEditHtml($displayWidth,
                                                                                                $employeeId,
                                                                                                $valueObject);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('FINAL_RESULT');
        $formId = 'edit_finalresult_form_' . $employeeId . '_' . $finalResultId;
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);

    }

    static function getHistoryPopupHtml($displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        Array /* EmployeeFinalResultValueObject */ $valueObjects)
    {
        $contentHtml = EmployeeFinalResultInterfaceBuilder::getHistoryHtml( $displayWidth,
                                                                            $employeeId,
                                                                            $valueObjects);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_LC('FINAL_RESULT');
        return ApplicationInterfaceBuilder::getInfoPopupHtml(   $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);
    }

}
?>
