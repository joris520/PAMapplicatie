<?php

/**
 * Description of SelfAssessmentReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportPageBuilder.class.php');
require_once('modules/interface/builder/reports/SelfAssessmentReportInterfaceBuilder.class.php');

class SelfAssessmentReportPageBuilder extends BaseReportPageBuilder
{

    // invitations
    static function getPageHtml($displayWidth,
                                $selectorWidth,
                                $doHilite,
                                $bossIdValues,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        return SelfAssessmentReportInterfaceBuilder::getViewHtml(   $displayWidth,
                                                                    $selectorWidth,
                                                                    $doHilite,
                                                                    $bossIdValues,
                                                                    $assessmentCycle);
    }

    static function getInvitationPopupHtml($displayWidth, $contentHeight, $employeeId, $invitationHash)
    {
        $contentHtml = SelfAssessmentReportInterfaceBuilder::getDetailHtml($displayWidth, $employeeId, $invitationHash);

        // popup
        $title = TXT_UCF('ADDITIONAL_INFO') . ' ' . TXT_LC('SELF_ASSESSMENT_INVITATION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    // dashboard
    static function getDashboardPageHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            SelfAssessmentDashboardCollection $dashboardCollection)
    {
        return SelfAssessmentReportInterfaceBuilder::getDashboardViewHtml(  $displayWidth,
                                                                            $selectorWidth,
                                                                            $doHilite,
                                                                            SelfAssessmentReportInterfaceBuilder::SHOW_TOTALS,
                                                                            $assessmentCycle,
                                                                            $dashboardCollection);
    }

    static function getDashboardDetailInvitationsPopupHtml( $displayWidth,
                                                            $contentHeight,
                                                            $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = SelfAssessmentReportInterfaceBuilder::getDashboardDetailInvitationsHtml( $displayWidth,
                                                                                                $bossId,
                                                                                                $assessmentCycle);

        // popup
        $title = TXT_UCF('SELF_ASSESSMENT_INVITED');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getDashboardDetailEmployeeStatusPopupHtml(  $displayWidth,
                                                                $contentHeight,
                                                                $bossId,
                                                                $completedStatus,
                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = SelfAssessmentReportInterfaceBuilder::getDashboardDetailEmployeeStatusHtml(  $displayWidth,
                                                                                                    $bossId,
                                                                                                    $completedStatus,
                                                                                                    $assessmentCycle);

        // popup
        if ($completedStatus == AssessmentInvitationCompletedValue::NOT_COMPLETED) {
            $title =    AssessmentInvitationCompletedConverter::image(AssessmentInvitationCompletedValue::NOT_COMPLETED) .
                        TXT_UCF('DASHBOARD_NOT_COMPLETED_BY_EMPLOYEE');
        } else {
            $title =    AssessmentInvitationCompletedConverter::image(AssessmentInvitationCompletedValue::COMPLETED) .
                        TXT_UCF('DASHBOARD_COMPLETED_BY_EMPLOYEE');
        }
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getDashboardDetailBossStatusPopupHtml(  $displayWidth,
                                                            $contentHeight,
                                                            $bossId,
                                                            $scoreStatus,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = SelfAssessmentReportInterfaceBuilder::getDashboardDetailBossStatusHtml(  $displayWidth,
                                                                                                $bossId,
                                                                                                $scoreStatus,
                                                                                                $assessmentCycle);

        // popup
        if ($scoreStatus == ScoreStatusValue::FINALIZED) {
            $title =    ScoreStatusConverter::image(ScoreStatusValue::FINALIZED) .
                        TXT_UCF('DASHBOARD_COMPLETED_BY_MANAGER');

        } else {
            $title =    ScoreStatusConverter::image(ScoreStatusValue::PRELIMINARY) .
                        TXT_UCF('DASHBOARD_NOT_COMPLETED_BY_MANAGER');
        }
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getDashboardDetailFullCompletedPopupHtml(   $displayWidth,
                                                                $contentHeight,
                                                                $bossId,
                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = SelfAssessmentReportInterfaceBuilder::getDashboardDetailFullCompletedHtml(   $displayWidth,
                                                                                                    $bossId,
                                                                                                    $assessmentCycle);

        // popup
        $title =    AssessmentInvitationCompletedConverter::image(AssessmentInvitationCompletedValue::COMPLETED) .
                    ScoreStatusConverter::image(ScoreStatusValue::FINALIZED) .
                    TXT_UCF('DASHBOARD_COMPLETED_BY_BOTH') ;
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }


}

?>
