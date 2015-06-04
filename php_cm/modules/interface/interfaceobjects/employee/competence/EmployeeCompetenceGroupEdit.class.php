<?php

/**
 * Description of EmployeeCompetenceGroupEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceCategoryGroupEdit.class.php');

class EmployeeCompetenceGroupEdit extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceGroupEdit.tpl';

    private $toggleNotesVisibilityLink;
    private $toggleNotesHtmlId;

    private $showRemarks;

    static function create($displayWidth)
    {
        return new EmployeeCompetenceGroupEdit( $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeCompetenceCategoryGroupEdit $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
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
