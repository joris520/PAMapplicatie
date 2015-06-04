<?php

/**
 * Description of EmployeeTargetPageBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/target/EmployeeTargetInterfaceBuilder.class.php');

class EmployeeTargetPageBuilder
{
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject,
                                Array $employeeTargetCollections,
                                $hiliteId = NULL)
    {

        return

                EmployeeTargetInterfaceBuilder::getEmployeeInfoHeaderHtml(  $displayWidth,
                                                                            $employeeId,
                                                                            $employeeInfoValueObject) .

                EmployeeTargetInterfaceBuilder::getActionsHtml( $displayWidth,
                                                                $employeeId ) .

                EmployeeTargetInterfaceBuilder::getViewHtml($displayWidth,
                                                            $employeeId,
                                                            $employeeTargetCollections,
                                                            $hiliteId );

    }

    // assessment
    static function getAddPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        $title = TXT_UCF('ADD') . ' ' . TXT_UCF('TARGET');
        $formId = 'add_employeetarget_form';

        list($safeFormHandler, $contentHtml) = EmployeeTargetInterfaceBuilder::getAddHtml($displayWidth, $employeeId);

        return ApplicationInterfaceBuilder::getAddPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getEditPopupHtml($displayWidth, $contentHeight, $employeeId, $employeeTargetId)
    {
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('TARGET');
        $formId = 'edit_employeetarget_form_' . $employeeTargetId;

        list($safeFormHandler, $contentHtml) = EmployeeTargetInterfaceBuilder::getEditHtml($displayWidth, $employeeId, $employeeTargetId);

        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getRemovePopupHtml($displayWidth, $contentHeight, $employeeId, $employeeTargetId)
    {
        $title = TXT_UCF('DELETE') . ' ' . TXT_UCF('TARGET');
        $formId = 'delete_employeetarget_form_' . $employeeTargetId;

        if (empty($employeeTargetId)) {
            $alertMessage = TXT_UCF('NO_VALUES_RETURNED');
            $contentHtml = ApplicationInterfaceBuilder::getInfoPopupHtml($title, $alertMessage, $displayWidth, $contentHeight);
        } else {

            list($safeFormHandler, $contentHtml) = EmployeeTargetInterfaceBuilder::getRemoveHtml($displayWidth, $employeeId, $employeeTargetId);
            return ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
        }
    }

    static function getHistoryPopupHtml($displayWidth, $contentHeight, $employeeId, $employeeTargetId)
    {
        $contentHtml = EmployeeTargetInterfaceBuilder::getHistoryHtml($displayWidth, $employeeId, $employeeTargetId, $contentHeight);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_UCF('TARGET');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getEditStatus($displayWidth, $employeeId, $employeeTargetId)
    {
        $formId = 'edit_employeetargetstatus_form_' . $employeeTargetId;

        list($safeFormHandler, $contentHtml) = EmployeeTargetInterfaceBuilder::getEditStatusHtml($displayWidth, $formId, $employeeId, $employeeTargetId);

        return ApplicationInterfaceBuilder::getInlineEditHtml($formId, $safeFormHandler, $contentHtml, $displayWidth);
    }

    static function getPrintOptionsPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        // de onderdelen van de pagina opbouwen
        list($safeFormHandler, $contentHtml) = EmployeeTargetInterfaceBuilder::getPrintOptionsHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('GENERATE_TARGET_PRINT');
        $formId = 'print_options_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getPrintOptionPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }
}

?>
