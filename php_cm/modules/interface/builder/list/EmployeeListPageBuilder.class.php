<?php

/**
 * Description of EmployeeListPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/list/EmployeeListInterfaceBuilder.class.php');
require_once('modules/interface/builder/list/EmployeeFilterInterfaceBuilder.class.php');
require_once('modules/interface/builder/assessmentProcess/AssessmentActionPageBuilder.class.php');


class EmployeeListPageBuilder
{

    // hier de EmployeeList opbouwen
    static function getPageHtml($displayWidth,
                                $listWidth,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        EmployeeFilterService::initializeSession();

        return (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ?
                AssessmentActionPageBuilder::getActionHtml( $listWidth,
                                                            $assessmentCycle) :
                '') .
               EmployeeFilterInterfaceBuilder::getViewHtml( $displayWidth,
                                                            $listWidth) .
               EmployeeListInterfaceBuilder::getViewHtml(   $displayWidth,
                                                            $listWidth,
                                                            $assessmentCycle);
    }

    static function getRemovePopupHtml( $displayWidth,
                                        $contentHeight,
                                        $employeeId)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE') . ' ' . TXT_LC('EMPLOYEE');

        $isRemovable = EmployeeProfileService::isRemovable($employeeId);
        if (!$isRemovable) {
            // TODO: betere html
            $contentHtml = TXT_UCF('CANNOT_DELETE_EMPLOYEE_BECAUSE_IT_IS_USED_AS_BOSS');
            $popupHtml = ApplicationInterfaceBuilder::getInfoPopupHtml( $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        $contentHeight);
        } else {
            list($safeFormHandler, $contentHtml) = EmployeeListInterfaceBuilder::getRemoveHtml( $displayWidth,
                                                                                                $employeeId);

            // popup
            $formId = 'remove_profile_form_' . $documentClusterId;
            $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml(   $formId,
                                                                            $safeFormHandler,
                                                                            $title,
                                                                            $contentHtml,
                                                                            $displayWidth,
                                                                            $contentHeight);
        }
        return array($popupHtml, $isRemovable);
    }

}

?>
