<?php

/**
 * Description of EmployeeResultView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

abstract class EmployeeResultView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeResultView.tpl';

    private $detailTemplateFile;

    private $employeeId;
    private $employeeName;

    private $isSelected;
    private $selectOnClick;
    private $deleteLink;

    private $employeeNameHtmlId;

    private $isAllowedArrowKeys;

    function __construct(   $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth,
                            $detailTemplateFile)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->detailTemplateFile   = $detailTemplateFile;
        $this->employeeId           = $employeeId;
        $this->employeeName         = $employeeName;
        $this->employeeNameHtmlId   = $employeeNameHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    function getEmployeeName()
    {
        return $this->employeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeNameHtmlId()
    {
        return $this->employeeNameHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDetailTemplateFile()
    {
        return $this->detailTemplateFile;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;
    }

    function isSelected()
    {
        return $this->isSelected;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelectOnClick($selectOnClick)
    {
        $this->selectOnClick = $selectOnClick;
    }

    function getSelectOnClick()
    {
        return $this->selectOnClick;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDeleteLink($deleteLink)
    {
        $this->deleteLink = $deleteLink;
    }

    function getDeleteLink()
    {
        return $this->deleteLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedArrowKeys($isAllowedArrowKeys)
    {
        $this->isAllowedArrowKeys = $isAllowedArrowKeys;
    }

    function isAllowedArrowKeys()
    {
        return $this->isAllowedArrowKeys;
    }

}

?>
