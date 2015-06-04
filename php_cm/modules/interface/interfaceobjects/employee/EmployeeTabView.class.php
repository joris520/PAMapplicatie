<?php

/**
 * Description of EmployeeTabView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeTabView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'employee/employeeTabView.tpl';

    private $welcomeMessage;
    private $employeeListHtml;

    static function create($displayWidth)
    {
        return new EmployeeTabView($displayWidth,
                                   self::TEMPLATE_FILE);
    }

    function setWelcomeMessage($welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }

    function getWelcomeMessage()
    {
        return $this->welcomeMessage;
    }

    function setEmployeeListHtml($employeeListHtml)
    {
        $this->employeeListHtml = $employeeListHtml;
    }

    function getEmployeeListHtml()
    {
        return $this->employeeListHtml;
    }

}

?>
