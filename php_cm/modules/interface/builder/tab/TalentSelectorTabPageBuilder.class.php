<?php

/**
 * Description of TalentSelectorTabPageBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/tab/TalentSelectorTabInterfaceBuilder.class.php');

class TalentSelectorTabPageBuilder
{
    static function getPageHtml($displayWidth,
                                $leftPanelWidth,
                                $rightPanelWidth)
    {
        return TalentSelectorTabInterfaceBuilder::getViewHtml(  $displayWidth,
                                                                $leftPanelWidth,
                                                                $rightPanelWidth);
    }
}

?>
