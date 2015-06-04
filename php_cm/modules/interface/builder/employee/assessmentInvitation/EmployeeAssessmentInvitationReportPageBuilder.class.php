<?php

/**
 * Description of EmployeeAssessmentInvitationReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/SelfAssessmentReportInterfaceBuilder.class.php');

class EmployeeAssessmentInvitationReportPageBuilder
{

    static function getPageHtml($displayWidth, $employeeId)
    {
        return SelfAssessmentReportInterfaceBuilder::getEmployeeViewHtml($displayWidth, $employeeId);
    }

}

?>
