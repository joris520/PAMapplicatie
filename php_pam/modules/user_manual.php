<?php

function moduleUserManual() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_USER_MANUAL);

        $getgt_data = '<div id="mode_department">
        <table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td>
        <table align="center"  style="width:670">
            <tr><td style="width:100%" >
                    <fieldset style="padding:10px;">
                    <legend>' . TXT_UCF('USER_MANUAL') . '</legend>
                    <br>
                    ' . TXT_UCF('USER_MANUAL') . ' In Progress..
                    </fieldset>
                    </td>
            </tr>
        </table><br><br>
        </td></tr></table><br />
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $getgt_data);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_USER_MANUAL));
    }

    return $objResponse;
}

?>
