<?php

require_once("./root_pam_config.inc.php");
require_once('application/library/safeFormConsts.inc.php');
require_once('application/library/safeDirectConsts.inc.php');
require_once('application/library/SafeFormHandler.class.php');

require_once('application/process/ApplicationSafeFormProcessor.class.php');
if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

define('MODULE_SUBSET', MODULE_SUBSET_UPLOAD_LOGO);
require_once('application/application_setup/pam_config.inc.php');

$upload_html = '<script type="text/javascript">parent.location.reload();</script>';
if (isset($user) && defined('CUSTOMER_ID') && PermissionsService::isEditAllowed(PERMISSION_THEMES)) {

//    require_once('application/application_setup/smarty_config.inc.php');

    require_once('modules/common/moduleConsts.inc.php');
    require_once("xajax/xajax_core/xajaxAIO.inc.php");   // xajax compiled
    //require_once("xajax/xajax_core/xajax.inc.php");    // xajax minimal
    $xajax = new xajax();

    $xajax->configure('debug', SITE_AJAX_DEBUG);
    require_once('application/application_setup/xajax_config.inc.php');  // hbd: hiervan is ook veel code niet nodig!

    require_once('modules/model/service/upload/LogoContent.class.php');
    $logoContent = new LogoContent();

    require_once('modules/themes.php');

    ////////////////////
    // SUBMIT afhandelen
    if (isset($_POST['submitButton'])) {
        list($isValidForm) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        // HP: todo: Een (nog te schrijven) functie aanroepen die de integriteit van het bestand checkt.
        // bijv: SafeUploadFormHandler::validateFileUpload($_POST['formIdentifier'])
        if ($isValidForm) {
            $upload_message = handle_upload_logo();
        }
    } else {
        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_THEME__UPLOAD_LOGO);
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
    }
    ////////////////////

    require_once('modules/model/queries/upload/LogoQueries.class.php');
    $current_logo_info = @mysql_fetch_assoc(LogoQueries::getCustomerLogoInfo());
    $g_logo = TXT_UCF('NO_CURRENT_LOGO') . '.<br>';
    if (!empty($current_logo_info['logo'])) {
        list($displayable_logo, $logo_width, $logo_height, $is_default_logo) = $logoContent->getCustomerDisplayableLogo($current_logo_info['logo'],
                                                                                                                        $current_logo_info['logo_size_width'],
                                                                                                                        $current_logo_info['logo_size_height']);
        if (!$is_default_logo) {
            $g_logo = '<br>
                       <div class="border1px" style="padding: 4px; width:' . $logo_width . 'px; height:' . $logo_height .  'px; margin-left:auto; margin-right:auto;">
                           <img width="' . $logo_width . '" height="' . $logo_height . '" src="' . $displayable_logo . '" style="border:none;" />
                       </div>';
        }
    }

    $upload_html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Upload Logo</title>
            <link href="css/layout.css" rel="stylesheet" type="text/css" />
            <link href="css/' . THEME . '.css" rel="stylesheet" type="text/css" />
            <style type="text/css">
                <!--
                label {
                    float:left;
                    display:block;
                    width:120px;
                }
                input {
                    float:left;
                }
                -->
            </style>
            <script type="text/javascript" src="js/general-functions.js"></script>
        </head>

        <body>
            <div style="padding: 10px;">';
                $upload_html .= $g_logo . '<br>';
                $upload_html .=
                TXT_UCF('MAX_FILESIZE') . ': ' . $logoContent->getMaxUploadFileSizeLabel() . '<br />' .
                TXT_UCF('ALLOWED_EXTENSIONS') . ':  ' . $logoContent->getAllowedUploadExtensionsText() . '<br/ >' . '
                <br /><strong>' . $upload_message . '</strong>
                <form name="thema_uploadlogo" enctype="multipart/form-data" method="post" action="'. $_SERVER['PHP_SELF'] . '">
                    ' . $formToken . '
                    ' . $formIdentifier . '
                    <input type="hidden" name="MAX_FILE_SIZE" value="' . $logoContent->getMaxUploadFileSize() . '"><br>
                    <table width="400" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="vertical-align:bottom; padding-bottom:5px;">' . TXT_UCF('PLEASE_BROWSE_A_LOGO') . ' ' . REQUIRED_FIELD_INDICATOR .'</td>
                            <td style="vertical-align:bottom; padding-bottom:5px;"><input type="file" name="upload" style="height: 21px;"></td>
                            <td><input type="submit" name="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </body>
    </html>';
}
echo $upload_html;
?>