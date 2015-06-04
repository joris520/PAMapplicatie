<?php

/**
 * Description of EmployeeListInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/list/EmployeeListInterfaceBuilder.class.php');
require_once('modules/process/tab/EmployeesTabInterfaceProcessor.class.php');

require_once('modules/model/service/library/AssessmentCycleService.class.php');

class EmployeeListInterfaceProcessor
{
    const DASHBOARD_DISPLAY_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;

    const ARCHIVE_CONTENT_HEIGHT = 200;
    const REMOVE_DIALOG_WIDTH = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const LIST_WIDTH = 280;

    // deze functie ook aanroepen als er iets bij een medewerker wijzigt waardoor de filter lijst mogelijk aangepast moet worden
    static function refreshEmployeeList(xajaxResponse  $objResponse)
    {
        // assessment cycles ophalen
        $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject(REFERENCE_DATE);

        $contentHtml = EmployeeListInterfaceBuilder::getResultContentHtml(self::LIST_WIDTH, $currentAssessmentCycle);
        InterfaceXajax::setHtml($objResponse, EmployeeListInterfaceBuilder::REPLACE_HTML_ID, $contentHtml);

        if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
            $actionHtml = AssessmentActionPageBuilder::getActionContentHtml(self::LIST_WIDTH, $currentAssessmentCycle);
            InterfaceXajax::setHtml($objResponse, AssessmentActionInterfaceBuilder::REPLACE_HTML_ID, $actionHtml);
        }
        if (CUSTOMER_OPTION_BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD) {
            $welcomeMessage = self::getWelcomeMessage($currentAssessmentCycle);
            InterfaceXajax::setHtml($objResponse, 'top_nav', '');
            InterfaceXajax::setHtml($objResponse, 'tabNav', '');
            InterfaceXajax::setHtml($objResponse, 'empPrint', $welcomeMessage);
        }

    }

    static function updateEmployeeNameInList(   xajaxResponse $objResponse,
                                                IdValue $employeeIdValue)
    {
        InterfaceXajax::setHtml($objResponse,
                                EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID . $employeeIdValue->getDatabaseId(),
                                $employeeIdValue->getValue());
    }

    static function getWelcomeMessage(AssessmentCycleValueObject $assessmentCycle)
    {
        $welcomeMessage = '';
        if (CUSTOMER_OPTION_USE_SELFASSESSMENT && EmployeeFilterService::hasActiveBossFilter()) {
            $bossIdValues = array(EmployeeSelectService::getBossIdValue(EmployeeFilterService::retrieveBossFilter()));
            $selfAssessmentDashboardCollection = SelfAssessmentReportService::getDashboardCollection($bossIdValues, $assessmentCycle);
            $welcomeMessage .=  '<h2>' . TXT_UCW('DASHBOARD_ASSESSMENT_COMPLETED') . '</h2>'.
                                SelfAssessmentReportInterfaceBuilder::getDashboardViewHtml(     self::DASHBOARD_DISPLAY_WIDTH,
                                                                                                SelfAssessmentReportInterfaceBuilder::HIDE_TOTALS,
                                                                                                $selfAssessmentDashboardCollection);
            if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                $assessmentProcessDashboardCollection = AssessmentProcessreportService::getDashboardCollection($bossIdValues, $assessmentCycle);
                $welcomeMessage .=  '<h2>' . TXT_UCW('DASHBOARD_ASSESSMENT_PROCESS') . '</h2>'.
                                    AssessmentProcessReportInterfaceBuilder::getDashboardViewHtml(  self::DASHBOARD_DISPLAY_WIDTH,
                                                                                                    SelfAssessmentReportInterfaceBuilder::HIDE_TOTALS,
                                                                                                    $assessmentProcessDashboardCollection);
            }
        }
        return $welcomeMessage;
    }


    static function displayRemoveEmployee($objResponse, $employeeId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            $employeeId != EMPLOYEE_ID) { // maar niet jezelf weggooien!

            list($popupHtml, $isRemovable) = EmployeeListPageBuilder::getRemovePopupHtml(   self::REMOVE_DIALOG_WIDTH,
                                                                                            self::ARCHIVE_CONTENT_HEIGHT,
                                                                                            $employeeId);

            $formStyle = $isRemovable ? POPUP_WARNING_STYLE : POPUP_ERROR_STYLE;
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::REMOVE_DIALOG_WIDTH,
                                                self::ARCHIVE_CONTENT_HEIGHT,
                                                FORM_DIALOG,
                                                $formStyle);
        }
    }

    static function finishRemoveEmployee($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele tab opnieuw opbouwen..
        if (ApplicationNavigationService::isSelectedEmployeeId($employeeId)) {
            ApplicationNavigationService::initializeSelectedEmployeeId();
            EmployeesTabInterfaceProcessor::displayViewPage($objResponse);
        } else {
            self::refreshEmployeeList($objResponse);
        }
    }

    static function toggleCheckboxBackground($objResponse, $employeeId, $checkedNewValue)
    {
        $htmlElementId  = EmployeeListInterfaceBuilder::CHECKBOX_COLOR_HTML_ID_PREFIX . $employeeId;
        $colorClass     = EmployeeListInterfaceBuilder::CHECKBOX_COLOR_CLASS;

        if ($checkedNewValue == 1) {
            InterfaceXajax::addClass($objResponse, $htmlElementId, $colorClass);
        } else { // vinkje uit, ontkleuren
            InterfaceXajax::removeClass($objResponse, $htmlElementId, $colorClass);
        }
        return $objResponse;
    }
}

?>
