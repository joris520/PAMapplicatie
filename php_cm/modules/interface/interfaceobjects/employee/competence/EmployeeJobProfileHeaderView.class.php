<?php

/**
 * Description of EmployeeJobProfileHeaderView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeJobProfileView.class.php');

class EmployeeJobProfileHeaderView extends EmployeeJobProfileView
{
    const TEMPLATE_FILE = 'employee/competence/employeeJobProfileHeaderView.tpl';

    private $editLink;
    private $historyLink;


    static function createWithValueObject(  EmployeeJobProfileValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeJobProfileHeaderView($valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEditLink()
    {
        return $this->editLink;
    }

    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
        $this->addActionLink($editLink);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getHistoryLink()
    {
        return $this->historyLink;
    }

    function setHistoryLink($historyLink)
    {
        $this->historyLink = $historyLink;
        $this->addActionLink($historyLink);
    }

}

?>
