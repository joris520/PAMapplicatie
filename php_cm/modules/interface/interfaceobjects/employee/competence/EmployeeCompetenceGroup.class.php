<?php

/**
 * Description of EmployeeCompetenceGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceCategoryGroup.class.php');

class EmployeeCompetenceGroup extends BaseGroupInterfaceObject
{

    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceGroup.tpl';

    private $toggleNotesHtmlId;

    static function create($displayWidth)
    {
        return new EmployeeCompetenceGroup( $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    function addInterfaceObject(EmployeeCompetenceCategoryGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
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
