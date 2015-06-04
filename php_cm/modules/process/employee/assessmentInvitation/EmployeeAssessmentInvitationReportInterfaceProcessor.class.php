<?php
/**
 * Description of EmployeeAssessmentInvitationReportInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/assessmentInvitation/EmployeeAssessmentInvitationReportPageBuilder.class.php');

class EmployeeAssessmentInvitationReportInterfaceProcessor
{
    static function displayView($objResponse, $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SELF_ASSESSMENT_OVERVIEW)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $viewHtml = EmployeeAssessmentInvitationReportPageBuilder::getPageHtml(ApplicationInterfaceBuilder::VIEW_WIDTH, $employeeId);
            }
            EmployeesTabInterfaceProcessor::displayContent($objResponse, $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu($objResponse, $employeeId, MODULE_EMPLOYEE_INVITATIONS);

        }
    }

}

?>
