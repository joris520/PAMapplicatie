<?php

/**
 * Description of EmployeeCompetenceScoreView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectsInterfaceObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeScoreValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceValueObject.class.php');

class EmployeeCompetenceScoreView extends BaseValueObjectsInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceScoreView.tpl';

    private $employeeCompetenceValueObject; // EmployeeCompetenceValueObject

    // meer data
    private $symbolIsKeyCompetence;
    private $symbolIsAdditionalCompetence;

    // optionele zelfevaluatie
    // current
    private $currentIsInvited;
    private $isAllowedViewCurrentEmployeeScore;
    private $isAllowedViewCurrentScore;
    private $currentSelfAssessmentScoreValueObject;
    private $currentDiffIndicator;
    // previous
    private $previousIsInvited;
    private $isAllowedViewPreviousEmployeeScore;
    private $isAllowedViewPreviousScore;
    private $previousSelfAssessmentScoreValueObject;
    private $previousDiffIndicator;

    // actions
    private $isInitialVisibleNotes;
    private $toggleNoteVisibilityLink;
    private $toggleNotePrefixId;

    private $historyLink;

    private $detailOnClick;
    private $detailLinkId;

    //
    private $hasNotes;

    private $showAnyRemarks;
    private $showBossRemarks;
    private $show360Remarks;

    private $show360;
    private $showNorm;
    private $showWeight;
    private $showPdpActions;

    // settings
    private $hasClusterMainCompetence;


    static function createWithValueObjects( EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                                            EmployeeScoreValueObject $currentScoreValueObject,
                                            EmployeeScoreValueObject $previousScoreValueObject,
                                            $displayWidth)
    {
        return new EmployeeCompetenceScoreView(  $employeeCompetenceValueObject,
                                                        $currentScoreValueObject,
                                                        $previousScoreValueObject,
                                                        $displayWidth);
    }

    function __construct(   EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                            EmployeeScoreValueObject $currentScoreValueObject,
                            EmployeeScoreValueObject $previousScoreValueObject,
                            $displayWidth)
    {
        parent::__construct($currentScoreValueObject,
                            $previousScoreValueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        $this->employeeCompetenceValueObject = $employeeCompetenceValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeCompetenceValueObject()
    {
        return $this->employeeCompetenceValueObject;
    }

    function getCurrentScoreValueObject()
    {
        return $this->getValueObject();
    }

    function getPreviousScoreValueObject()
    {
        return $this->getPreviousValueObject();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCurrentSelfAssessmentScoreValueObject(EmployeeSelfAssessmentScoreValueObject $currentSelfAssessmentScoreValueObject)
    {
        $this->currentSelfAssessmentScoreValueObject = $currentSelfAssessmentScoreValueObject;
    }

    function getCurrentSelfAssessmentScoreValueObject()
    {
        return $this->currentSelfAssessmentScoreValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPreviousSelfAssessmentScoreValueObject(EmployeeSelfAssessmentScoreValueObject $previousSelfAssessmentScoreValueObject)
    {
        $this->previousSelfAssessmentScoreValueObject = $previousSelfAssessmentScoreValueObject;
    }

    function getPreviousSelfAssessmentScoreValueObject()
    {
        return $this->previousSelfAssessmentScoreValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHasClusterMainCompetence($hasClusterMainCompetence)
    {
        $this->hasClusterMainCompetence = $hasClusterMainCompetence;
    }

    function hasClusterMainCompetence()
    {
        return $this->hasClusterMainCompetence;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSymbolIsKeyCompetence($symbolIsKeyCompetence)
    {
        $this->symbolIsKeyCompetence = $symbolIsKeyCompetence;
    }

    function getIsKeySymbol()
    {
        return $this->symbolIsKeyCompetence;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSymbolIsAdditionalCompetence($symbolIsAdditionalCompetence)
    {
        $this->symbolIsAdditionalCompetence = $symbolIsAdditionalCompetence;
    }

    function getSymbolIsAdditionalCompetence()
    {
        return $this->symbolIsAdditionalCompetence;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedViewCurrentScore($isAllowedViewCurrentScore)
    {
        $this->isAllowedViewCurrentScore = $isAllowedViewCurrentScore;
    }

    function isAllowedViewCurrentScore()
    {
        return $this->isAllowedViewCurrentScore;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedViewCurrentEmployeeScore($isAllowedViewCurrentEmployeeScore, $currentIsInvited)
    {
        $this->isAllowedViewCurrentEmployeeScore    = $isAllowedViewCurrentEmployeeScore;
        $this->currentIsInvited                     = $currentIsInvited;
    }

    function isAllowedViewCurrentEmployeeScore()
    {
        return $this->isAllowedViewCurrentEmployeeScore;
    }

    function currentIsInvited()
    {
        return $this->currentIsInvited;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedViewPreviousScore($isAllowedViewPreviousScore)
    {
        $this->isAllowedViewPreviousScore = $isAllowedViewPreviousScore;
    }

    function isAllowedViewPreviousScore()
    {
        return $this->isAllowedViewPreviousScore;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedViewPreviousEmployeeScore($isAllowedViewPreviousEmployeeScore,
                                                   $previousIsInvited)
    {
        $this->isAllowedViewPreviousEmployeeScore   = $isAllowedViewPreviousEmployeeScore;
        $this->previousIsInvited                    = $previousIsInvited;
    }

    function isAllowedViewPreviousEmployeeScore()
    {
        return $this->isAllowedViewPreviousEmployeeScore;
    }

    function previousIsInvited()
    {
        return $this->previousIsInvited;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCurrentDiffIndicator($currentDiffIndicator)
    {
        $this->currentDiffIndicator = $currentDiffIndicator;
    }

    function getCurrentDiffIndicator()
    {
        return $this->currentDiffIndicator;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPreviousDiffIndicator($previousDiffIndicator)
    {
        $this->previousDiffIndicator = $previousDiffIndicator;
    }

    function getPreviousDiffIndicator()
    {
        return $this->previousDiffIndicator;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHistoryLink($historyLink)
    {
        $this->historyLink = $historyLink;
    }

    function getHistoryLink()
    {
        return $this->historyLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNoteVisibilityLink($toggleNoteVisibilityLink)
    {
        $this->toggleNoteVisibilityLink = $toggleNoteVisibilityLink;
    }

    function getToggleNoteVisibilityLink()
    {
        return $this->toggleNoteVisibilityLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setToggleNotePrefixId($toggleNotePrefixId)
    {
        $this->toggleNotePrefixId = $toggleNotePrefixId;
    }

    function getToggleNoteId($competenceId)
    {
        return $this->toggleNotePrefixId . $competenceId;
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
    function setHasNotes($hasNotes)
    {
        $this->hasNotes = $hasNotes;
    }

    function hasNotes()
    {
        return $this->hasNotes;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowAnyRemarks($showAnyRemarks)
    {
        $this->showAnyRemarks = $showAnyRemarks;
    }

    function showAnyRemarks()
    {
        return $this->showAnyRemarks;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowBossRemarks($showBossRemarks)
    {
        $this->showBossRemarks = $showBossRemarks;
    }

    function showBossRemarks()
    {
        return $this->showBossRemarks;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShow360Remarks($show360Remarks)
    {
        $this->show360Remarks = $show360Remarks;
    }

    function show360Remarks()
    {
        return $this->show360Remarks;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShow360($show360)
    {
        $this->show360 = $show360;
    }

    function show360()
    {
        return $this->show360;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowNorm($showNorm)
    {
        $this->showNorm = $showNorm;
    }

    function showNorm()
    {
        return $this->showNorm;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowWeight($showWeight)
    {
        $this->showWeight = $showWeight;
    }

    function showWeight()
    {
        return $this->showWeight;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowPdpActions($showPdpActions)
    {
        $this->showPdpActions = $showPdpActions;
    }

    function showPdpActions()
    {
        return $this->showPdpActions;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDetailOnClick($detailOnClick)
    {
        $this->detailOnClick = $detailOnClick;
    }

    function getDetailOnClick()
    {
        return $this->detailOnClick;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDetailLinkId($detailLinkId)
    {
        $this->detailLinkId = $detailLinkId;
    }

    function getDetailLinkId()
    {
        return $this->detailLinkId;
    }

}

?>
