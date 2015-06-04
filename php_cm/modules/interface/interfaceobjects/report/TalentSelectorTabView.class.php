<?php

/**
 * Description of TalentSelectorTabView
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class TalentSelectorTabView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorTabView.tpl';

    private $leftPanelWidth;
    private $rightPanelWidth;
    private $leftPanelId;
    private $rightPanelId;

    function create($displayWidth,
                    $leftPanelWidth,
                    $rightPanelWidth,
                    $leftPanelId,
                    $rightPanelId)
    {
        return new TalentSelectorTabView(   $displayWidth,
                                            $leftPanelWidth,
                                            $rightPanelWidth,
                                            $leftPanelId,
                                            $rightPanelId);
    }

    protected function __construct( $displayWidth,
                                    $leftPanelWidth,
                                    $rightPanelWidth,
                                    $leftPanelId,
                                    $rightPanelId)
    {
        parent::__construct($displayWidth, self::TEMPLATE_FILE);

        $this->leftPanelWidth   = $leftPanelWidth;
        $this->rightPanelWidth  = $rightPanelWidth;
        $this->leftPanelId      = $leftPanelId ;
        $this->rightPanelId     = $rightPanelId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLeftPanelWidth ()
    {
        return $this->leftPanelWidth;
    }

    function getRightPanelWidth ()
    {
        return $this->rightPanelWidth;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getLeftPanelId ()
    {
        return $this->leftPanelId;
    }

    function getRightPanelId ()
    {
        return $this->rightPanelId;
    }
}

?>
