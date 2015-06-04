<?php

/**
 * Description of EmployeeCompetenceClusterGroupEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreView.class.php');

class EmployeeCompetenceClusterGroupEdit extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceClusterGroupEdit.tpl';

    // display data
    private $clusterName;

    // instellingen
    private $competenceWidth;
    private $scoreWidth;
    private $actionsWidth;

    private $clusterHasMainCompetence;
    private $showClusterInfo;

    private $toggleNotesHtmlId;
    private $toggleNotesVisibilityLink;

    static function create( $displayWidth,
                            $clusterName)
    {
        return new EmployeeCompetenceClusterGroupEdit(  $displayWidth,
                                                        $clusterName);
    }

    protected function __construct( $displayWidth,
                                    $clusterName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->clusterName      = $clusterName;
    }

    function getClusterName()
    {
        return $this->clusterName;
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
    function addInterfaceObject(EmployeeCompetenceScoreEdit $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowClusterInfo($showClusterInfo)
    {
        $this->showClusterInfo = $showClusterInfo;
    }

    function showClusterInfo()
    {
        return $this->showClusterInfo;
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

}

?>
