<?php

/**
 * Description of TalentSelectorTabInterfaceBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/report/TalentSelectorTabView.class.php');

class TalentSelectorTabInterfaceBuilder
{
    static function getViewHtml($displayWidth, $leftPanelWidth, $rightPanelWidth)
    {
        $interfaceObject = TalentSelectorTabView::create(   $displayWidth,
                                                            $leftPanelWidth,
                                                            $rightPanelWidth,
                                                            TalentSelectorInterfaceBuilder::LEFT_PANEL_HTML_ID,
                                                            TalentSelectorInterfaceBuilder::RIGHT_PANEL_HTML_ID);

        return $interfaceObject->fetchHtml();
    }
}

?>
