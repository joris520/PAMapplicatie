<?php

/**
 * Description of EmployeeFinalResultView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectsInterfaceObject.class.php');

class EmployeeFinalResultView extends BaseValueObjectsInterfaceObject
{
    const TEMPLATE_FILE = 'employee/finalResult/employeeFinalResultView.tpl';

    const TOTAL_NOTE_NAME       = 'total';
    const BEHAVIOUR_NOTE_NAME   = 'behaviour';
    const RESULTS_NOTE_NAME     = 'results';

    private $instructionText;

    private $showRemarks;
    private $showDetailScores;

    private $isInitialVisibleNotes;
    private $toggleNotesVisibilityLink;
    private $toggleNotesHtmlId;
    private $toggleNotePrefixId;

    private $toggleNoteVisibilityLinks;

    static function createWithValueObjects( EmployeeFinalResultValueObject $valueObject,
                                            EmployeeFinalResultValueObject $previousValueObject,
                                            $displayWidth)
    {
        return new EmployeeFinalResultView( $valueObject,
                                            $previousValueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInstructionText($instructionText)
    {
        $this->instructionText = $instructionText;
    }

    function getInstructionText()
    {
        return $this->instructionText;
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
    function setToggleNotePrefixId($toggleNotePrefixId)
    {
        $this->toggleNotePrefixId = $toggleNotePrefixId;
    }

    function getToggleNoteId($noteName)
    {
        return $this->toggleNotePrefixId . $noteName;
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
    function setToggleNoteVisibilityLink(   $noteName,
                                            $toggleTotalScoreNoteVisibilityLink)
    {
        $this->toggleNoteVisibilityLinks[$noteName] = $toggleTotalScoreNoteVisibilityLink;
    }

    function getToggleNoteVisibilityLink($noteName)
    {
        return $this->toggleNoteVisibilityLinks[$noteName];
    }

}

?>
