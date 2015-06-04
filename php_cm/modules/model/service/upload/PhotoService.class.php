<?php

/**
 * Description of PhotoService
 *
 * @author ben.dokter
 */

require_once('modules/model/service/upload/DocumentContentService.class.php');

class PhotoService extends DocumentContentService
{

    static function placePhotoInFilePath($contentId, $photoFile)
    {
        // ophalen content...
        $photoFilePath = CustomerService::getPhotoPath() . $photoFile;
        self::copyContentToCustomerFilePath(CUSTOMER_ID, $contentId, $photoFilePath);

    }

    static function deletePhotoFile($photoFile)
    {
        return self::deleteContentFile(CustomerService::getPhotoPath(), $photoFile);
    }

}

?>
