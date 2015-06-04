<?php

require_once('application/model/service/UserLoginService.class.php');

require_once('application/interface/converter/TimeConverter.class.php');
require_once('application/interface/converter/NumberConverter.class.php');

require_once('modules/common/moduleConsts.inc.php');

function setSessionLanguage($prefered_language_id = null)
{
    if ($prefered_language_id != LanguageValue::LANG_ID_EN ||
        $prefered_language_id != LanguageValue::LANG_ID_NL) {
        $prefered_language_id = null;
    }

    if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
        $_SESSION['lang_en'] = LanguageValue::LANG_ID_EN;
    } else {
        $_SESSION['lang_en'] = !empty($prefered_language_id) ? $prefered_language_id : LanguageValue::LANG_ID_NL;
    }
}

function moduleLogin_processLogin($aFormValues)
{
    if (array_key_exists('username', $aFormValues)) {
        setSessionLanguage();
        return processAccountData($aFormValues);
    }
}

function processAccountData($aFormValues)
{
    $objResponse = new xajaxResponse();

    $username = trim($aFormValues['username']);
    $password = trim($aFormValues['password']);
    $language_id = intval($aFormValues['language_id']);

    $loginError = LOGIN_STATUS_NO_ERROR;

    $validLogin = false;
    if (!empty($username) && !empty($password) && $username != '' && $password != '') {
        list (  $user_found,
                $user_id) = UserLoginService::getUserLoginInfo($username);

        if ($user_found) {
            if (UserLoginService::isUsernamePasswordValid($username, $password)) {

                UserLoginService::updateLastLogin($user_id);

                // hbd: we gaan inloggen als een andere gebruiker, dus nieuwe sessie starten
                $_SESSION = array();
                session_destroy();
                // hbd: aanmaken nieuwe sessieid
                session_start();
                session_regenerate_id(true);
                // hbd: gebruiker in sessie bewaren. moet eigenlijk username uit query zijn!
                PamApplication::storeCurrentUser(trim($username));

                // dit cookie zorgt er voor dat na het sluiten van de browser je ook opnieuw moet inloggen
                setcookie(PamApplication::COOKIE_PAM_BROWSER, time(), 0, '/');

                InterfaceXajax::reloadApplication($objResponse);
                $validLogin = true;
            } else {
                $loginError = LOGIN_STATUS_INVALID;
            }
        } else {
            $loginError = LOGIN_STATUS_INVALID;
        }
    }

    if (!$validLogin) {
        if ($language_id == LanguageValue::LANG_ID_EN) {
            $message = 'Invalid Username or Password. ' . "\n";
        } else {
            $message = 'De combinatie van Gebruikersnaam en Wachtwoord is niet geldig. ' . "\n";
        }
        $objResponse->alert($message);
        $objResponse->assign("submitButton", "disabled", false);

        $objResponse->script('xajax.$("username").focus();');
        $objResponse->assign('username', 'value', '');
        $objResponse->assign('password', 'value', '');
    }

    return $objResponse;
}


?>
