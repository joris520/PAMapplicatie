<?php

require_once('application/interface/ApplicationInterfaceBuilder.class.php');

function getBodyOnload()
{
    $onLoad = "";
    if (!PAM_DISABLED) {
        if (PamApplication::hasCurrentUser()) {
            if (PamApplication::isSysAdminUser()) {
                $onLoad =  'onLoad="xajax_moduleCustomers_displayCustomers();"';
            } else {
                if (USER_LEVEL == UserLevelValue::EMPLOYEE_EDIT || USER_LEVEL == UserLevelValue::EMPLOYEE_VIEW) {
                    $load_employee_id = EMPLOYEE_ID;
                } else {
                    $load_employee_id = null;
                }
                $onLoad = 'onLoad="xajax_public_navigation_startApplication(' . $load_employee_id . ')"';
            }
        } else {
            $onLoad = 'onLoad="document.getElementById(\'username\').focus()"';
        }
    }
    return $onLoad;
}

function getHeaderLogo()
{
    $header_logo = '<img src="' . USER_LOGO_FILE_URL . '" border="0" width="' . LOGO_WIDTH . '" height="' . LOGO_HEIGHT . '" />';
    return $header_logo;
}

?>