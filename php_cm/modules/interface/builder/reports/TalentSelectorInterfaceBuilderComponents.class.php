<?php

/**
 * Description of TalentSelectorInterfaceBuilderComponents
 *
 * @author hans.prins
 */

class TalentSelectorInterfaceBuilderComponents
{
    static function getClearLink()
    {
        $html = '';
        if (PermissionsService::isExecuteAllowed(PERMISSION_TALENT_SELECTOR)) {
            $html .= InterfaceBuilder::iconLink('clear_talent_selector',
                                                TXT_UCF('CLEAR'),
                                                'xajax_public_report__displayTalentSelector();',
                                                ICON_CANCEL);
        }
        return $html;
    }
}

?>