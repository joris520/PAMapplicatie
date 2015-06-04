<?php
require_once("./root_pam_config.inc.php");
require_once('application/library/safeFormConsts.inc.php');
require_once('application/library/safeDirectConsts.inc.php');
require_once('application/library/SafeFormHandler.class.php');

if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

define('MODULE_SUBSET', MODULE_SUBSET_UPLOAD_PHOTO);
require_once('application/application_setup/pam_config.inc.php');

if (isset($user) && defined('CUSTOMER_ID') && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

    require_once("xajax/xajax_core/xajaxAIO.inc.php");   // xajax compiled
    //require_once("xajax/xajax_core/xajax.inc.php");    // xajax minimal
    $xajax = new xajax();

    $xajax->configure('debug', SITE_AJAX_DEBUG);
    require_once('application/application_setup/xajax_config.inc.php');  // hbd: hiervan is ook veel code niet nodig!

    require_once('modules/model/service/upload/PhotoContent.class.php');
    require_once('modules/model/service/to_refactor/EmployeeProfileServiceDeprecated.class.php');

    $photoContent = new PhotoContent();

    ////////////////////
    // SUBMIT afhandelen
    $employee_id = $_SESSION['ID_E'];
    if (isset($_POST['submitButton'])) {
        list($isValidForm) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        // handle_upload_photo was al refactored, en staat nu in employee_photo_upload.inc.php
        if ($isValidForm) {
            require_once('modules/public/uploads/employee_photo_upload.inc.php');
            $upload_message = handle_upload_photo($employee_id);
        }
    } else {
        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_PROFILE__UPLOAD_PHOTO);
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
    }
    ////////////////////
    // TODO: refactor, zie upload_evaluation_attachment

    $upload_html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Upload Photo</title>
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
        </head>

        <body>
            <div style="padding: 10px;">';
                $upload_html .=
                TXT_UCF('MAX_FILESIZE') . ' : ' . $photoContent->getMaxUploadFileSizeLabel() . '<br />' .
                TXT_UCF('ALLOWED_EXTENSIONS') . ' :  ' . $photoContent->getAllowedUploadExtensionsText() . '<br/ >' . '
                <br /><strong>' . $upload_message . '</strong>
                <form name="form1" enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                ' . $formToken . '
                ' . $formIdentifier . '
                    <input type="hidden" name="MAX_FILE_SIZE" value="' . $photoContent->getMaxUploadFileSize() . '"><br>
                    <table width="430" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="vertical-align:bottom; padding-bottom:5px;">' . TXT_UCF('BROWSE_PHOTO') . ' : </td>
                            <td style="vertical-align:bottom; padding-bottom:5px;"><input type="file" name="upload" style="height: 21px;"></td>
                            <td style="vertical-align:bottom; ">&nbsp; <input type="submit" name="submitButton" value="' . TXT_BTN('UPLOAD_PHOTO') . '" class="btn btn_width_80"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </body>
    </html>';
}
echo $upload_html;
?>