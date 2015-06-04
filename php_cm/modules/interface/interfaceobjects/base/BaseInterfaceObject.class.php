<?php

/**
 * Description of BaseInterfaceObject
 *
 * @author ben.dokter
 */

require_once('application/interface/interfaceobjects/BaseApplicationInterfaceObject.class.php');

class BaseInterfaceObject extends BaseApplicationInterfaceObject
{
    private $emptyMessage;

    var $diffClass;
    var $noLinkSpaces;

    private $actionLinks;
    private $actionId;
    private $actionsWidth;



    protected function __construct( $displayWidth,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);
        
        $this->actionLinks          = array();
        $this->actionId             = '';

        // "constanten"
        $this->actionsWidth             = ApplicationInterfaceBuilder::DEFAULT_ACTIONS_WIDTH;
        $this->emptyMessage             = TXT_UCF('NO_VALUES_RETURNED');
        $this->diffClass                = 'warning-text';
        $this->noLinkSpaces             = ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES;
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getNoLinkSpaces()
    {
        return $this->noLinkSpaces;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmptyMessage($emptyMessage)
    {
        $this->emptyMessage = $emptyMessage;
    }

    function displayEmptyMessage()
    {
        return '<em>' . $this->emptyMessage . '</em>';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addActionLink($actionLink)
    {
        $this->actionLinks[] = $actionLink;
    }

    function getActionLinks()
    {
        return implode($this->actionLinks, ' ');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setActionId($actionId)
    {
        $this->actionId = $actionId;
    }

    function getActionId()
    {
        return $this->actionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setActionsWidth($actionsWidth)
    {
        $this->actionsWidth = $actionsWidth;
    }

    function getActionsWidth()
    {
        return $this->actionsWidth . 'px';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function diff($value1, $value2)
    {
        return ($value1 == $value2)  ? '' : $this->diffClass;
    }

}

?>
