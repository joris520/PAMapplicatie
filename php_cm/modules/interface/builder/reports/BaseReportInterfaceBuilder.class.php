<?php

/**
 * Description of BaseReportInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/report/BaseReportPeriodDatesEdit.class.php');

class BaseReportInterfaceBuilder
{
    const REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE = 'report_assessment_cycle_selector';


    static function getAssessmentCycleSelectorLinkHtml( $displayWidth,
                                                        $formId,
                                                        $reportMode,
                                                        Array $assessmentCycleIdValues,
                                                        $selectedAssessmentCycleId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_REPORT__INLINE_ASSESSMENT_CYCLE_SELECTOR);
        $safeFormHandler->storeSafeValue('report_mode', $reportMode);
        $safeFormHandler->addIntegerInputFormatType('assessment_cycle');
        $safeFormHandler->finalizeDataDefinition();

        // data
        $safeFormIdentifier = $safeFormHandler->getFormIdentifier();

        $interfaceObject    = BaseReportAssessmentCycleInlineSelector::create(  $safeFormIdentifier,
                                                                                $formId,
                                                                                $displayWidth);
        $interfaceObject->setIdValues(      $assessmentCycleIdValues);
        $interfaceObject->setCurrentId(     $selectedAssessmentCycleId);
        $interfaceObject->setCancelLink(    BaseReportInterfaceBuilderComponents::getCancelInlineSelectorLink());

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getEditReportDatesHtml( $displayWidth,
                                            $reportMode,
                                            $selectedAssessmentCycleStartDate,
                                            $selectedAssessmentCycleEndDate)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_REPORT__EDIT_REPORT_PERIOD_DATES);
        $safeFormHandler->storeSafeValue('report_mode', $reportMode);
        $safeFormHandler->addDateInputFormatType('start_date');
        $safeFormHandler->addDateInputFormatType('end_date');
        $safeFormHandler->finalizeDataDefinition();


        $interfaceObject = BaseReportPeriodDatesEdit::create($displayWidth);
        $interfaceObject->setStartDatePicker(   InterfaceBuilderComponents::getCalendarInputPopupHtml(  'start_date',
                                                                                                        $selectedAssessmentCycleStartDate));
        $interfaceObject->setEndDatePicker(     InterfaceBuilderComponents::getCalendarInputPopupHtml(  'end_date',
                                                                                                        $selectedAssessmentCycleEndDate));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
