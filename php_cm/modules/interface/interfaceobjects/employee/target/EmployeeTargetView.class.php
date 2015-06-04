<?php

/**
 * Description of EmployeeTargetView
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeTargetView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetView.tpl';

    private $editLink;
    private $removeLink;
    private $historyLink;
    private $dateWarning;

    private $isViewAllowedEvaluation;

    static function createWithValueObject(  EmployeeTargetValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeTargetView(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsViewAllowedEvaluation($isViewAllowedEvaluation)
    {
        $this->isViewAllowedEvaluation = $isViewAllowedEvaluation;
    }

    function isViewAllowedEvaluation()
    {
        return $this->isViewAllowedEvaluation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $editLink
    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
    }

    function getEditLink()
    {
        return $this->editLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $removeLink
    function setRemoveLink($removeLink)
    {
        $this->removeLink = $removeLink;
    }

    function getRemoveLink()
    {
        return $this->removeLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyLink
    function setHistoryLink($historyLink)
    {
        $this->historyLink = $historyLink;
    }

    function getHistoryLink()
    {
        return $this->historyLink;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $dateWarning
    function setDateWarning($dateWarning)
    {
        $this->dateWarning = $dateWarning;
    }

    function hasDateWarning()
    {
        return $this->dateWarning;
    }

}

?>