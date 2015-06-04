<?php

/**
 * Description of EmployeeFinalResultInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/finalResult/EmployeeFinalResultInterfaceBuilderComponents.class.php');


require_once('modules/interface/interfaceobjects/employee/finalResult/EmployeeFinalResultView.class.php');
require_once('modules/interface/interfaceobjects/employee/finalResult/EmployeeFinalResultEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/finalResult/EmployeeFinalResultHistory.class.php');

require_once('modules/interface/state/TotalScoreEditType.class.php');
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');
require_once('modules/interface/converter/library/competence/TotalScoreConverter.class.php');

require_once('modules/model/service/employee/finalResult/EmployeeFinalResultService.class.php');

class EmployeeFinalResultInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{
    const FINAL_RESULT_NOTE_VIEW_HTML_ID      = 'final_result_toggle_view_notes_block';
    const FINAL_RESULT_NOTE_VIEW_PREFIX       = 'view_comment_row_';
    const FINAL_RESULT_NOTE_EDIT_HTML_ID      = 'final_result_toggle_edit_notes_block';
    const FINAL_RESULT_NOTE_EDIT_PREFIX       = 'edit_comment_row_';
    const FINAL_RESULT_NOTE_INITIAL_VISIBLE   = FALSE;


    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeFinalResultValueObject $valueObject,
                                EmployeeFinalResultValueObject $previousValueObject)
    {

        $showRemarks        = CUSTOMER_OPTION_USE_SKILL_NOTES;
        $showDetailScores   = CUSTOMER_OPTION_SHOW_FINAL_RESULT_DETAIL_SCORES;

        // omzetten naar template data
        $interfaceObject = EmployeeFinalResultView::createWithValueObjects( $valueObject,
                                                                            $previousValueObject,
                                                                            $displayWidth);

        $interfaceObject->setInstructionText(   TXT_UCF('FINAL_RESULT_EXPLANATION_A') . '. ' .
                                                TXT_UCF('FINAL_RESULT_EXPLANATION_B') . '.');

        $interfaceObject->setShowRemarks(               $showRemarks);
        $interfaceObject->setShowDetailScores(          $showDetailScores);

        if ($showRemarks) {
            $interfaceObject->setToggleNotesHtmlId(         self::FINAL_RESULT_NOTE_VIEW_HTML_ID);
            $interfaceObject->setToggleNotePrefixId(        self::FINAL_RESULT_NOTE_VIEW_PREFIX);
            $interfaceObject->setIsInitialVisibleNotes(     self::FINAL_RESULT_NOTE_INITIAL_VISIBLE);

            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultView::TOTAL_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_VIEW_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_VIEW_PREFIX,
                                                                                                                                            EmployeeFinalResultView::TOTAL_NOTE_NAME));
            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_VIEW_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_VIEW_PREFIX,
                                                                                                                                            EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME));
            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultView::RESULTS_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_VIEW_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_VIEW_PREFIX,
                                                                                                                                            EmployeeFinalResultView::RESULTS_NOTE_NAME));
        }
        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('FINAL_RESULT'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(       EmployeeFinalResultInterfaceBuilderComponents::getEditLink(      $employeeId));
        if ($showRemarks) {
            $blockInterfaceObject->addActionLink(   EmployeeScoreInterfaceBuilderComponents::getToggleNotesVisibilityLink(   self::FINAL_RESULT_NOTE_VIEW_HTML_ID));
        }

        $blockInterfaceObject->addActionLink(       EmployeeFinalResultInterfaceBuilderComponents::getHistoryLink(   $employeeId));

        return $blockInterfaceObject->fetchHtml();
    }

    static function getEditHtml($displayWidth,
                                $employeeId,
                                EmployeeFinalResultValueObject $valueObject)
    {
        $showRemarks            = CUSTOMER_OPTION_USE_SKILL_NOTES;

        $isAllowedDetailScores  = EmployeeFinalResultService::isAllowedDetailScores();
        $totalScoreEditType     = EmployeeFinalResultService::getTotalScoreEditType();


        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_FINAL_RESULT);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);

        $safeFormHandler->addIntegerInputFormatType('total_score');
        $safeFormHandler->addStringInputFormatType ('total_score_comments');
        if ($isAllowedDetailScores) {
            $safeFormHandler->addIntegerInputFormatType('behaviour_score');
            $safeFormHandler->addStringInputFormatType ('behaviour_score_comment');
            $safeFormHandler->addIntegerInputFormatType('results_score');
            $safeFormHandler->addStringInputFormatType ('results_score_comment');
        }

        $safeFormHandler->addDateInputFormatType   ('assessment_date');
        $safeFormHandler->finalizeDataDefinition();

        if (!$valueObject->hasAssessmentDate()) {
            $valueObject->setAssessmentDate(    DateUtils::getCurrentDatabaseDate());
        }

        $interfaceObject = EmployeeFinalResultEdit::createWithValueObject(  $valueObject,
                                                                            $displayWidth);

        $interfaceObject->setAssessmentDatePicker(  InterfaceBuilderComponents::getCalendarInputPopupHtml(  'assessment_date',
                                                                                                            $valueObject->getAssessmentDate()));
        $interfaceObject->setShowRemarks(           CUSTOMER_OPTION_USE_SKILL_NOTES);
        $interfaceObject->setTotalResultLegenda(    InterfaceBuilderComponents::getFinalResultLegendaHtml());
        $interfaceObject->setShowDetailScores(      $isAllowedDetailScores);
        $interfaceObject->setDetailScoreLegenda(    InterfaceBuilderComponents::getScoreLegendaHtml());
        $interfaceObject->setTotalScoreEditType(    $totalScoreEditType);
        $interfaceObject->setTotalScoreIdValues(    EmployeeFinalResultService::getTotalScoreIdValues());

        if ($showRemarks) {
            $interfaceObject->setToggleNotesHtmlId(         self::FINAL_RESULT_NOTE_EDIT_HTML_ID);
            $interfaceObject->setToggleNotePrefixId(        self::FINAL_RESULT_NOTE_EDIT_PREFIX);
            $interfaceObject->setIsInitialVisibleNotes(     self::FINAL_RESULT_NOTE_INITIAL_VISIBLE);

            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultEdit::TOTAL_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_EDIT_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_EDIT_PREFIX,
                                                                                                                                            EmployeeFinalResultEdit::TOTAL_NOTE_NAME));
            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_EDIT_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_EDIT_PREFIX,
                                                                                                                                            EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME));
            $interfaceObject->setToggleNoteVisibilityLink(  EmployeeFinalResultEdit::RESULTS_NOTE_NAME,
                                                            EmployeeFinalResultInterfaceBuilderComponents::getToggleViewNoteVisibilityLink( self::FINAL_RESULT_NOTE_EDIT_HTML_ID,
                                                                                                                                            self::FINAL_RESULT_NOTE_EDIT_PREFIX,
                                                                                                                                            EmployeeFinalResultEdit::RESULTS_NOTE_NAME));

            $interfaceObject->setToggleNotesVisibilityLink( EmployeeScoreInterfaceBuilderComponents::getToggleNotesVisibilityLink(          self::FINAL_RESULT_NOTE_EDIT_HTML_ID));
        }

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getHistoryHtml( $displayWidth,
                                    $employeeId,
                                    Array /* EmployeeFinalResultValueObject */ $valueObjects)
    {
        $interfaceObject = EmployeeFinalResultHistory::create($displayWidth);
        $interfaceObject->setShowRemarks(       CUSTOMER_OPTION_USE_SKILL_NOTES);
        $interfaceObject->setShowDetailScores(  CUSTOMER_OPTION_SHOW_FINAL_RESULT_DETAIL_SCORES);

        foreach ($valueObjects as $valueObject) {
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDatetime());
            $valueObject->setAssessmentCycleValueObject($historyPeriod);

            $interfaceObject->addValueObject($valueObject);
        }

        return $interfaceObject->fetchHtml();
    }

}

?>
