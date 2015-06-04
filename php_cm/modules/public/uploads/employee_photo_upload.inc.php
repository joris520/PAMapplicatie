<?php

require_once('modules/model/service/upload/PhotoContent.class.php');
require_once('modules/model/service/to_refactor/EmployeeProfileServiceDeprecated.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfilePersonalService.class.php');
require_once('modules/common/moduleConsts.inc.php');


function handle_upload_photo($id_e)
{
    // oude photo info ophalen...
//    $old_photo = EmployeeProfileServiceDeprecated::getPhotoInfo(CUSTOMER_ID, $id_e);

    $photoContent = new PhotoContent();
    // De nieuwe foto uploaden, schalen en in de DocumentContents tabel opslaan.
    list ($hasError, $messageTxt) = $photoContent->processSetPhoto($id_e);

    if (!$hasError) {
        //via de sessie onthouden welke oploaded is..
        EmployeeProfilePersonalService::storeUploadedPhotoContentId($photoContent->id_contents);
    }
    return $messageTxt;
}

?>