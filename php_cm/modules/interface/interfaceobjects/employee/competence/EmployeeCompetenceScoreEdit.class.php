<?php

/**
 * Description of EmployeeCompetenceScoreEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeCompetenceScoreEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceScoreEdit.tpl';

    private $employeeCompetenceValueObject;

    private $scoreInputName;
    private $noteInputName;

    // instellingen
    private $showRemarks;
    private $showNorm;
    private $isEmptyAllowed;
    private $hasClusterMainCompetence;

    private $competenceWidth;
    private $scoreWidth;
    private $actionsWidth;

    // display data
    private $categoryId;
    private $categoryName;
    private $clusterId;
    private $clusterName;

    private $symbolIsKeyCompetence;
    private $symbolIsAdditionalCompetence;

    private $detailOnClick;
    private $detailLinkId;

    private $toggleNoteVisibilityLink;
    private $toggleNotePrefixId;
    private $isInitialVisibleNotes;

    // keep alive
    var $keepAliveCallback;

    static function createWithValueObjects( EmployeeScoreValueObject $valueObject,
                                            EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                                            $displayWidth)
    {
        return new EmployeeCompetenceScoreEdit( $valueObject,
                                                $employeeCompetenceValueObject,
                                                $displayWidth);
    }

    function __construct(   EmployeeScoreValueObject $valueObject,
                            EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                            $displayWidth)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        $this->employeeCompetenceValueObject = $employeeCompetenceValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCompetenceValueObject()
    {
        return $this->employeeCompetenceValueObject;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setWidths($competenceWidth, $scoreWidth, $actionsWidth)
    {
        $this->competenceWidth  = $competenceWidth;
        $this->scoreWidth       = $scoreWidth;
        $this->actionsWidth     = $actionsWidth;
    }

    function getCompetenceWidth()
    {
        return $this->getDisplayStyle($this->competenceWidth);
    }

    function getScoreWidth()
    {
        return $this->getDisplayStyle($this->scoreWidth);
    }

    function getActionsWidth()
    {
        return $this->getDisplayStyle($this->actionsWidth);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCategoryInfo($categoryId, $categoryName)
    {
        $this->categoryId    = $categoryId;
        $this->categoryName  = $categoryName;
    }

    function getCategoryId()
    {
        return $this->categoryId;
    }

    function getCategoryName()
    {
        return $this->categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterInfo($clusterId, $clusterName)
    {
        $this->clusterId    = $clusterId;
        $this->clusterName  = $clusterName;
    }

    function getClusterId()
    {
        return $this->clusterId;
    }

    function getClusterName()
    {
        return $this->clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setScoreInputName($scoreInputName)
    {
        $this->scoreInputName = $scoreInputName;
    }

    function getScoreInputName()
    {
        return $this->scoreInputName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setNoteInputName($noteInputName)
    {
        $this->noteInputName = $noteInputName;
    }

    function getNoteInputName()
    {
        return $this->noteInputName;
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
    function setShowNorm($showNorm)
    {
        $this->showNorm = $showNorm;
    }

    function showNorm()
    {
        return $this->showNorm;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsEmptyAllowed($isEmptyAllowed)
    {
        $this->isEmptyAllowed = $isEmptyAllowed;
    }

    function isEmptyAllowed()
    {
        return $this->isEmptyAllowed;
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
    // truukje om de sessie-timeout bij het score edit scherm bij actief gebruik te voorkomen
    function setKeepAliveCallback($keepAliveCallback)
    {
        $this->keepAliveCallback = $keepAliveCallback;
    }

    function getKeepAliveCallback()
    {
        return $this->keepAliveCallback;
    }
}

?>
