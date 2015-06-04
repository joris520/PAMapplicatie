<?php

function moduleLogin_logOut() {
    $objResponse = new xajaxResponse();
    header("Pragma: no-cache");
    header("Cache: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Tue, 24 Jan 1984 05:00:00 GMT");
    // hbd: taal bewaren.
    // TODO: via cookie; sessie kan al verlopen zijn
    $lang_param='';
    if ($_SESSION['lang_en'] == LanguageValue::LANG_ID_EN) {
        $lang_param='en';
    }
    //hbd: opruimen sessie data
    $_SESSION = array();
    session_destroy();

    // hbd: aanmaken nieuwe session-id
    session_start();
    session_regenerate_id(true);
    InterfaceXajax::reloadApplication($objResponse, 'lang=' . $lang_param);
    return $objResponse;
}

?>
