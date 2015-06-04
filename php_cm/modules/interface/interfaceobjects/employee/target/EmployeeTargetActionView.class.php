<?php

/**
 * Description of EmployeeTargetActionView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeTargetActionView extends BaseInterfaceObject
{
    private $addLink;
    private $printLink;

    static function create($displayWidth)
    {
        return new EmployeeTargetActionView($displayWidth);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $addLink
    function setAddLink($addLink)
    {
        $this->addLink = $addLink;
    }

    function getAddLink()
    {
        return $this->addLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $printLink
    function setPrintLink($printLink)
    {
        $this->printLink = $printLink;
    }

    function getPrintLink()
    {
        return $this->printLink;
    }
}

?>
