<?php

/**
 * Description of EmployeeListView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeListView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeListView.tpl';

    private $replaceHtmlId;
    private $filteredEmployees;
    private $addLink;

    static function create($displayWidth)
    {
        return new EmployeeListView($displayWidth,
                                    self::TEMPLATE_FILE);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setReplaceHtmlId($replaceHtmlId)
    {
        $this->replaceHtmlId = $replaceHtmlId;
    }

    function getReplaceHtmlId()
    {
        return $this->replaceHtmlId;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setFilteredEmployees(EmployeeResultGroup $filteredEmployees)
    {
        $this->filteredEmployees = $filteredEmployees;
    }

    function getFilteredEmployees()
    {
        return $this->filteredEmployees;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAddLink($addLink)
    {
        $this->addLink = $addLink;
    }

    function getAddLink()
    {
        return $this->addLink;
    }

}

?>
