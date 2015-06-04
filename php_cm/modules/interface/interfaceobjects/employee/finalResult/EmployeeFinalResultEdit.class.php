<?php

/**
 * Description of EmployeeFinalResultEdit
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeFinalResultEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/finalResult/employeeFinalResultEdit.tpl';

    const TOTAL_NOTE_NAME       = 'total';
    const BEHAVIOUR_NOTE_NAME   = 'behaviour';
    const RESULTS_NOTE_NAME     = 'results';

    private $assessmentDatePicker;
    private $detailScoreLegenda;
    private $totalResultLegenda;

    private $showRemarks;
    private $showDetailScores;

    private $totalScoreEditType;
    private $totalScoreIdValues;

    private $isInitialVisibleNotes;
    private $toggleNotesVisibilityLink;
    private $toggleNotesHtmlId;
    private $toggleNotePrefixId;

    private $toggleNoteVisibilityLinks;



    static function createWithValueObject(  EmployeeFinalResultValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeFinalResultEdit( $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowRemarks($showRemarks)
    {
        $this->showRemarks = $showRemarks;
    }

    function showRemarks()
    {
        return $this->showRemarks;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowDetailScores($showDetailScores)
    {
        $this->showDetailScores = $showDetailScores;
    }

    function showDetailScores()
    {
        return $this->showDetailScores;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalScoreEditType($totalScoreEditType)
    {
        $this->totalScoreEditType = $totalScoreEditType;
    }

    function getTotalScoreEditType()
    {
        return $this->totalScoreEditType;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalScoreIdValues($totalScoreIdValues)
    {
        $this->totalScoreIdValues = $totalScoreIdValues;
    }

    function getTotalScoreIdValues()
    {
        return $this->totalScoreIdValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDetailScoreLegenda($detailScoreLegenda)
    {
        $this->detailScoreLegenda = $detailScoreLegenda;
    }

    function getDetailScoreLegenda()
    {
        return $this->detailScoreLegenda;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalResultLegenda($totalResultLegenda)
    {
        $this->totalResultLegenda = $totalResultLegenda;
    }

    function getTotalResultLegenda()
    {
        return $this->totalResultLegenda;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentDatePicker($assessmentDatePicker)
    {
        $this->assessmentDatePicker = $assessmentDatePicker;
    }

    function getAssessmentDatePicker()
    {
        return $this->assessmentDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsInitialVisibleNotes($isInitialVisibleNotes)
    {
        $this->isInitialVisibleNotes = $isInitialVisibleNotes;
    }

    function isInitialVisibleNotes()
    {
        return $this->isInitialVisibleNotes;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNotesHtmlId($toggleNotesHtmlId)
    {
        $this->toggleNotesHtmlId = $toggleNotesHtmlId;
    }

    function getToggleNotesHtmlId()
    {
        return $this->toggleNotesHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNotesVisibilityLink($toggleNotesVisibilityLink)
    {
        $this->toggleNotesVisibilityLink = $toggleNotesVisibilityLink;
    }

    function getToggleNotesVisibilityLink()
    {
        return $this->toggleNotesVisibilityLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNotePrefixId($toggleNotePrefixId)
    {
        $this->toggleNotePrefixId = $toggleNotePrefixId;
    }

    function getToggleNoteId($noteName)
    {
        return $this->toggleNotePrefixId . $noteName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNoteVisibilityLink($noteName, $toggleTotalScoreNoteVisibilityLink)
    {
        $this->toggleNoteVisibilityLinks[$noteName] = $toggleTotalScoreNoteVisibilityLink;
    }

    function getToggleNoteVisibilityLink($noteName)
    {
        return $this->toggleNoteVisibilityLinks[$noteName];
    }

}

?>
