<?php

    require_once("./root_pam_config.inc.php");
    if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

    define('MODULE_SUBSET', MODULE_SUBSET_DOWNLOAD_DB);

    require_once ('application/application_setup/pam_config.inc.php');
    require_once('modules/common/moduleUtils.class.php');

if (isset($user) &&
    ModuleUtils::isValidLogin() && // korte check of we ingelogd zijn volgens pam_config
    ( PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS) || PermissionsService::isViewAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE))) {
    // of we mogen de attachments zien of het zelfassessment process staat aan, dan moet de functioneringsgesprekbijlage ook getoond kunnen worden.
    require_once('modules/model/service/upload/FileContent.class.php');
    require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');

    $did = is_numeric($_GET['d']) ? intval($_GET['d']): NULL;
    $id_e = is_numeric($_GET['e']) ? intval($_GET['e']) : NULL;

    $contents_query = DocumentQueries::getEmployeesDocumentContent($did, $id_e);

    if(@mysql_num_rows($contents_query) == 0) {
        header('Location: ' . SITE_URL);
        ModuleUtils::ForceLogout();
    }

    $contents_result = @mysql_fetch_assoc($contents_query);

    $file_name = $contents_result['document_name'];
    $file_extension = $contents_result['file_extension'];
    $file_size = $contents_result['contents_size'];
    $file_contents = $contents_result['contentsBase64'];

    // required for IE, otherwise Content-disposition is ignored
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    $ctypes = FileContent::getMimeTypesForExtension($file_extension);

    // prepare headers
    header('Pragma: public'); // required
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false); // required for certain browsers
    header('Content-Type: ' . $ctypes[0]); // de eerste is goed zat...

    // 2010-04-01 replaced by Gijs
    header('Content-Disposition: attachment; filename="' . $file_name.  '";');

    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . $file_size);
    echo FileContent::getDecodedContents($file_contents);
    exit();
} else {
    header('Location: ' . SITE_URL);
    ModuleUtils::ForceLogout();
}
?>