<?php

/**
 * Description of BaseReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilder.class.php');

class BaseReportPageBuilder
{
    static function getAssessmentCycleSelectorLinkHtml( $displayWidth,
                                                        $reportMode,
                                                        Array $assessmentCycleIdValues,
                                                        $selectedAssessmentCycleId)
    {
        $formId = 'inline_assessment_cycle_selector_form';

        list($safeFormHandler, $contentHtml) = BaseReportInterfaceBuilder::getAssessmentCycleSelectorLinkHtml(  $displayWidth,
                                                                                                                $formId,
                                                                                                                $reportMode,
                                                                                                                $assessmentCycleIdValues,
                                                                                                                $selectedAssessmentCycleId);

        return ApplicationInterfaceBuilder::getInlineEditHtml(  $formId,
                                                                $safeFormHandler,
                                                                $contentHtml,
                                                                $displayWidth);
    }

    static function getEditReportDatesPopupHtml($displayWidth,
                                                $contentHeight,
                                                $reportMode,
                                                $selectedAssessmentCycleStartDate,
                                                $selectedAssessmentCycleEndDate)
    {
        list($safeFormHandler, $contentHtml) = BaseReportInterfaceBuilder::getEditReportDatesHtml(  $displayWidth,
                                                                                                    $reportMode,
                                                                                                    $selectedAssessmentCycleStartDate,
                                                                                                    $selectedAssessmentCycleEndDate);

        // popup
        $title = TXT_UCF('DEFINE_REPORT_PERIOD');
        $formId = 'edit_report_period_form';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING);
    }

}
?>
