<?php

/**
 * Description of EmployeeCompetenceScoreGroupEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeCompetenceScoreGroupEdit extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceScoreGroupEdit.tpl';

    private $clusterHasMainCompetence;
    private $toggleNotesHtmlId;
    private $toggleNotesVisibilityLink;

    private $showRemarks;

    private $competenceWidth;
    private $scoreWidth;
    private $actionsWidth;

    static function create($displayWidth)
    {
        return new EmployeeCompetenceScoreGroupEdit($displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeCompetenceScoreEdit $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
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
    function setClusterHasMainCompetence($clusterHasMainCompetence)
    {
        $this->clusterHasMainCompetence = $clusterHasMainCompetence;
    }

    function getClusterHasMainCompetence()
    {
        return $this->clusterHasMainCompetence;
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
    function setToggleNotesHtmlId($toggleNotesHtmlId)
    {
        $this->toggleNotesHtmlId = $toggleNotesHtmlId;
    }

    function getToggleNotesHtmlId()
    {
        return $this->toggleNotesHtmlId;
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

}
?>
