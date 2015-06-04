<?php

require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');
require_once('modules/model/queries/upload/LogoQueries.class.php');
require_once('modules/model/service/upload/LogoService.class.php');

require_once('gino/ImageUtils.class.php');



function moduleOptions_themeLogo() {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_THEMES)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_THEMES);

        $_SESSION['customer_id'] = CUSTOMER_ID;

        $logoHtml   = '
            <div id="tabNav">' .
                ApplicationNavigationInterfaceBuilder::buildThemeMenu(MODULE_THEMES_LOGO) . '
            </div>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <br>
                        <div id="colours">
                            <table border="0" cellspacing="0" cellpadding="5" width="590" align="center" class="">
                                <tr>
                                    <td>
                                        <div id="nlogo"></div>';
            if (PermissionsService::isEditAllowed(PERMISSION_THEMES)) {
                $logoHtml .= '
                                        <div id="logoDiv">
                                            <iframe src ="upload_logo.php" width="99%" height="300" frameBorder="0">
                                            <p>Your browser does not support iframes.</p>
                                            </iframe>
                                            &nbsp; <input type="button" value="' . TXT_BTN('RESET_LOGO') . '" class="btn btn_width_80" onclick="xajax_moduleOptions_resetThemeLogo();return false;">
                                        </div>';
            }
            $logoHtml .= '
                                        <br />
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </div>
                    </td>
                </tr>
            </table>';

        $themeTitle = TXT_UCF('THEMES');
        $logoBlock = BaseBlockHtmlInterfaceObject::create($themeTitle, 600);
        $logoBlock->setContentHtml($logoHtml);

        $html = '
        <div id="mode_department">
            <table align="center">
                <tr>
                    <td>
                        ' . $logoBlock->fetchHtml() . '
                        <br/>
                    </td>
                </tr>
            </table>
        </div>';


        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_THEMES));

    }
    return $objResponse;
}

function moduleOptions_editThemeColour() {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_THEMES)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_OPTIONS__EDIT_THEMECOLOUR);

        $safeFormHandler->addIntegerInputFormatType('radio');

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    theme_id
                FROM
                    customers
                WHERE
                    customer_id = ' . CUSTOMER_ID;
        $customerQuery = BaseQueries::performQuery($sql);
        $get_customer_theme = @mysql_fetch_assoc($customerQuery);

        $sql = 'SELECT
                    *
                FROM
                    themes'; // applicatie breed
        $themesQuery = BaseQueries::performQuery($sql);

        $html = '
        <table border="0" cellspacing="0" cellpadding="5" width="400" align="center" class="border1px">
            <tr>
                <td>
                    <form id="userForm" name="userForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

            $html .= $safeFormHandler->getTokenHiddenInputHtml();

            if (@mysql_num_rows($themesQuery) > 0) {
                $html .= '
                <table width="100%" cellspacing="1" cellpadding="5">
                    <tr>
                        <td class="bottom_line shaded_title">
                            <strong>' . TXT_UCF('SELECT') . '</strong>
                        </td>
                        <td width="70%" class="bottom_line shaded_title" width="20%">
                            <strong>' . TXT_UCF('THEME_COLOUR') . '</strong>
                        </td>
                    </tr>';
                while ($theme = @mysql_fetch_assoc($themesQuery)) {
                    $checked = $theme[ID_T] == $get_customer_theme['theme_id'] ? 'checked' : '';
                    $html .= '
                    <tr>
                        <td class="bottom_line">
                            <input type="radio" name="radio" value="' . $theme[ID_T] . '" ' . $checked . '>
                        </td>
                        <td class="bottom_line">' . TXT_UCF($theme[theme_name]) . '</td>
                    </tr>';
                }
                $html .= '
                    <tr>
                        <td colspan="100%">
                            <input id="submitButton" type="submit" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                            <input id="theme_reset" type="button" value="' . TXT_BTN('RESET_COLOUR') . '" class="btn btn_width_80" onclick="xajax_moduleOptions_resetThemeColour();return false;">
                        </td>
                    </tr>
                </table>';
            }

            $html .= '
                    </form>
                </td>
            </tr>
        </table>
        <br>';

        $objResponse->assign('colours', 'innerHTML', $html);
        $objResponse->assign('tabNav', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildThemeMenu(MODULE_THEMES_COLOUR));
    }
    return $objResponse;
}

function moduleOptions_editThemeLanguage()
{

    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_THEMES)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_OPTIONS__EDIT_THEMELANGUAGE);

        $safeFormHandler->addIntegerInputFormatType('lang_id');

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    lang_id
                FROM
                    customers
                WHERE
                    customer_id = ' . CUSTOMER_ID;
        $customerLangQuery = BaseQueries::performQuery($sql);
        $get_customer_lang = @mysql_fetch_assoc($customerLangQuery);

        $html = '
    	<table border="0" cellspacing="0" cellpadding="5" width="400" align="center" class="border1px">
        	<tr>
                <td>
                    <form id="langform" name="langform" method="post" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

                    $sql = 'SELECT
                                *
                            FROM
                                languages';
                    $languagesQuery = BaseQueries::performQuery($sql);

                    if (@mysql_num_rows($languagesQuery) > 0) {
                        $html .= '
                        <table width="100%" cellspacing="1" cellpadding="5">
                            <tr>
                                <td class="">
                                    <strong>' . TXT_UCF('SELECT_LANGUAGE') . ' ' . REQUIRED_FIELD_INDICATOR . '</strong>
                                </td>
                            </tr>';
                        while ($lang = @mysql_fetch_assoc($languagesQuery)) {
                            $checked = $lang[lang_id] == $get_customer_lang['lang_id'] ? 'checked' : '';
                                $html .= '
                            <tr>
                                <td class="bottom_line">
                                    <input id="language_selector_' . $lang['lang_id'] . '" type="radio" name="lang_id" value="' . $lang['lang_id'] . '" ' . $checked . '>
                                    &nbsp;&nbsp;<label for="language_selector_' . $lang['lang_id'] . '">' . $lang['language'] . '</label>
                                </td>
                            </tr>';
                        }
                        $html .= '
                            <tr>
                                <td colspan="100%" >
                                    <div id="themeBtn">
                                            <input id="submitButton" type="submit" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                                            <input id="language_reset" type="button" value="' . TXT_BTN('RESET_LANGUAGE') . '" class="btn btn_width_150" onclick="xajax_moduleOptions_resetThemeLanguage();return false;">
                                    </div>
                                </td>
                            </tr>
                        </table>';
                    }

                    $html .= '
                    </form>
                </td>
            </tr>
        </table>
        <br>';
        $objResponse->assign('colours', 'innerHTML', $html);
        $objResponse->assign('tabNav', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildThemeMenu(MODULE_THEMES_LANGUAGE));

    }
    return $objResponse;
}

function options_processSafeForm_editThemeLanguage($objResponse, $safeFormHandler) {
    return set_customer_lang($objResponse, $safeFormHandler->retrieveInputValue('lang_id'));
}

function moduleOptions_resetThemeLanguage() {
    $objResponse = new xajaxResponse();
    set_customer_lang($objResponse, DEFAULT_LANG_ID);
    return $objResponse;
}

// local function
function set_customer_lang($objResponse, $lang_id)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_THEMES)) {
        BaseQueries::startTransaction();

        $sql = 'UPDATE
                    customers
                SET
                    lang_id = ' . $lang_id . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';
        BaseQueries::performUpdateQuery($sql);

        BaseQueries::finishTransaction();
        $hasError = false;
        $message = TXT_UCF('SAVED');

        $objResponse->script('javascript:location.reload(true)');
    }
    return array($hasError, $message);
}


function options_processSafeForm_editThemeColour($objResponse, $safeFormHandler) {
    return set_customer_theme($objResponse, $safeFormHandler->retrieveInputValue('radio'));
}

function moduleOptions_resetThemeColour() {
    $objResponse = new xajaxResponse();
    set_customer_theme($objResponse, THEME_DEFAULT_ID);
    return $objResponse;
}

// local function
function set_customer_theme($objResponse, $theme_id)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_THEMES)) {
        BaseQueries::startTransaction();

        $sql = 'UPDATE
                    customers
                SET
                    theme_id = ' . $theme_id . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';
        BaseQueries::performUpdateQuery($sql);

        BaseQueries::finishTransaction();
        $hasError = false;
        $message = TXT_UCF('SAVED');

        $objResponse->script('javascript:location.reload(true)');
    }
    return array($hasError, $message);
}


// TODO: refactor!!
function handle_upload_logo()
{
    // TODO: valid session?
    $logoContent = new LogoContent();
    // Het nieuwe logo uploaden, schalen en in de DocumentContents tabel of als bestand opslaan.
    list ($hasError, $messageTxt) = $logoContent->processSetLogo();

    if (!$hasError) {
        // oude logo bestand verwijderen
        $old_logo = @mysql_fetch_assoc(LogoQueries::getCustomerLogoInfo());
        try {
            if (!empty($old_logo['logo'])) {
                @unlink(CUSTOMER_LOGO_PATH . $old_logo['logo']);
            }
        } catch (TimecodeException $ignore) {
            // file kan weg zijn.
        }

        // nieuw logo info opslaan
        LogoQueries::updateCustomerLogoInfo(    $logoContent->local_name,
                                                $logoContent->logo_width,
                                                $logoContent->logo_height,
                                                $logoContent->id_contents);

        // Na het updaten de oude DocumentContents verwijderen
        if (!empty($old_logo['id_contents'])) {
            DocumentQueries::deleteDocumentContent($old_logo['id_contents']);
        }

        // we moeten nu het bestand uit de database restoren in het customer logo path
        LogoService::placeLogoInCustomerFilePath(CUSTOMER_ID);
        $response_html = '<script type="text/javascript">parent.location.reload();</script>';
    } else {
        $response_html = '<span class="error">' . $messageTxt . '</span>';
    }
    return $response_html;
}

function moduleOptions_resetThemeLogo()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_THEMES)) {
        $old_logo_info = @mysql_fetch_assoc(LogoQueries::getCustomerLogoInfo());
        // logo info opschonen
        // todo: via service...
        LogoQueries::clearCustomerLogoInfo();

        // bestand verwijderen
        if (!empty($old_logo_info['logo'])) {
            @unlink(CUSTOMER_LOGO_PATH . $old_logo_info['logo']);
        }
        // de DocumentContents verwijderen
        if (!empty($old_logo_info['id_contents'])) {
            DocumentQueries::deleteDocumentContent($old_logo_info['id_contents']);
        }

        InterfaceXajax::reloadApplication($objResponse);
    }
    return $objResponse;
}

?>
