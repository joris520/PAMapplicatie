<?php

/**
 * Description of AssessmentProcessReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/AssessmentProcessReportInterfaceBuilder.class.php');
require_once('modules/interface/builder/library/AssessmentCycleInterfaceBuilder.class.php');

class AssessmentProcessReportPageBuilder
{

    static function getDashboardPageHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            AssessmentProcessDashboardCollection $dashboardCollection)
    {
        // TODO: template
//        return  '<h1>' . TXT_UCW('DASHBOARD_ASSESSMENT_PROCESS') . '</h1>' .
//
//                AssessmentCycleInterfaceBuilder::getDetailHtml( $displayWidth,
//                                                                $assessmentCycle) .
        return  AssessmentProcessReportInterfaceBuilder::getDashboardViewHtml(  $displayWidth,
                                                                                $selectorWidth,
                                                                                $doHilite,
                                                                                SelfAssessmentReportInterfaceBuilder::SHOW_TOTALS,
                                                                                $assessmentCycle,
                                                                                $dashboardCollection);
    }

    static function getDashboardDetailPhasePopupHtml(   $displayWidth,
                                                        $contentHeight,
                                                        $bossId,
                                                        $assessmentProcessStatusValue,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = AssessmentProcessReportInterfaceBuilder::getDashboardDetailPhaseHtml($displayWidth,
                                                                                            $bossId,
                                                                                            $assessmentProcessStatusValue,
                                                                                            $assessmentCycle);

        // popup
        switch($assessmentProcessStatusValue) {
            case AssessmentProcessStatusValue::INVITED:
                $title = TXT_UCF('DASHBOARD_PHASE1_DESCRIPTION');
                break;
            case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED:
                $title = TXT_UCF('DASHBOARD_PHASE2_DESCRIPTION');
                break;
            case AssessmentProcessStatusValue::EVALUATION_SELECTED:
                $title = TXT_UCF('DASHBOARD_PHASE3_DESCRIPTION');
                break;
            default:
                $title = '** UNKNOWN REQUEST: ' . $assessmentProcessStatusValue;
        }
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);

    }


    static function getDashboardDetailEvaluationNonePopupHtml( $displayWidth,
                                                               $contentHeight,
                                                               $bossId,
                                                               AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = AssessmentProcessReportInterfaceBuilder::getDashboardDetailEvaluationNoneHtml(  $displayWidth,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
        // popup
        $title = TXT_UCF('DASHBOARD_PHASE3_NO_DESCRIPTION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getDashboardDetailEvaluationPlannedPopupHtml(   $displayWidth,
                                                                    $contentHeight,
                                                                    $bossId,
                                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = AssessmentProcessReportInterfaceBuilder::getDashboardDetailEvaluationPlannedHtml($displayWidth,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
        // popup
        $title = TXT_UCF('DASHBOARD_PHASE3_PLANNED_DESCRIPTION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getDashboardDetailEvaluationReadyPopupHtml( $displayWidth,
                                                                $contentHeight,
                                                                $bossId,
                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = AssessmentProcessReportInterfaceBuilder::getDashboardDetailEvaluationReadyHtml( $displayWidth,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
        // popup
        $title = TXT_UCF('DASHBOARD_PHASE3_READY_DESCRIPTION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);

    }
}

?>
