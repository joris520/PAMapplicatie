<?php

/**
 * Description of PhotoContent
 *
 * @author ben.dokter
 */
require_once('modules/model/service/upload/FileContent.class.php');
require_once('modules/model/service/to_refactor/EmployeeProfileServiceDeprecated.class.php');
require_once('gino/ImageUtils.class.php');

class PhotoContent extends FileContent {

    var $photo_width = 0;
    var $photo_height = 0;
    var $id_e = null;

    function copyDBPhotoToCustomerPhotoPath($customer_id, $id_e)
    {
        // ophalen content...
        $employee_photo = EmployeeProfileServiceDeprecated::getPhotoContents($customer_id, $id_e);
        $photo_content_size = $employee_photo['contents_size'];
        $photo_file = ModuleUtils::getCustomerPhotoPath($customer_id) . $employee_photo['foto_thumbnail'];
        // converteren en wegschrijven content
        FileContent::writeImageContentToFile($photo_file,
                                             FileContent::getDecodedContents($employee_photo['contentsBase64']),
                                             $photo_content_size);
    }

    static function placeDbPhotoInCustomerPhotoPath($contentId)
    {
        // ophalen content...
        $employee_photo = self::getPhotoContent($contentId);
        $photo_content_size = $employee_photo['contents_size'];
        $photo_file = ModuleUtils::getCustomerPhotoPath($customer_id) . $employee_photo['foto_thumbnail'];
        // converteren en wegschrijven content
        FileContent::writeImageContentToFile($photo_file,
                                             FileContent::getDecodedContents($employee_photo['contentsBase64']),
                                             $photo_content_size);
    }


    // hbd: todo: hier schaalspul inzetten
    // en bestand in database of uploads zetten
    function processFileContent($tempfile_name, $upload_mime, $document_name, $document_extension)
    {

        $this->message = TXT_UCF('PHOTO_STORED');
        list($file_width, $file_height) = ImageUtils::getImageSizeFromFile($tempfile_name);
        list($photo_width, $photo_height, $width_offset, $height_offset ) = ImageUtils::calculatePhotoSize($file_width, $file_height, DEFAULT_PHOTO_WIDTH, DEFAULT_PHOTO_HEIGHT);

        $simg = ImageUtils::getImageInMemory($tempfile_name, $upload_mime);
        if (! empty($simg)) {
            $newImage = ImageUtils::rescaleImage($simg, $file_width, $file_height, $photo_width, $photo_height, $photo_width, $photo_height, $width_offset, $height_offset);

            $this->photo_width = $photo_width;
            $this->photo_height = $photo_height;
            $this->local_name = FileContent::generateLocalFilename() . '.' . $document_extension;
            list($contents_size, $contents) = ImageUtils::getJpegInMemory($newImage);
            $this->id_contents = FileContent::insertContentInDatabase($document_name, $document_extension, $contents, $contents_size);
            if ($this->id_contents <= 0) {
                $this->has_error = true;
                $this->message = TXT_UCF('CANNOT_STORE_FILE_IN_DATABASE');
            }
            imagedestroy($newImage);
        }
        return $this->has_error;
    }

    function getAllowedUploadExtensions()
    {
        return ImageUtils::getAllowedImageExtensions();
    }

    function getMaxUploadFileSize()
    {
        return MAX_PHOTO_BYTESIZE;
    }

    function getMaxUploadFileSizeLabel()
    {
        return ($this->getMaxUploadFileSize()/1024) . ' kB';
    }

    function processSetPhoto($id_e)
    {
        $this->id_e = $id_e;
        $hasError = $this->uploadAndProcessFile();
        $alertTxt = $this->message;
        return array($hasError, $alertTxt);
    }

    function getEmployeePrintablePhoto($foto_thumbnail)
    {
        return $this->getEmployeeValidPhoto($foto_thumbnail, array('.jpg'));
    }

    function getEmployeeDisplayablePhoto($foto_thumbnail)
    {
        return $this->getEmployeeValidPhoto($foto_thumbnail, $this->getAllowedUploadExtensions());
    }

    function getEmployeeValidPhoto($foto_thumbnail, $a_extensions)
    {
        $displayable_photo = '';
        $file_width = DEFAULT_PHOTO_WIDTH;
        $file_height = DEFAULT_PHOTO_HEIGHT;
        $foto_thumbnail_file = CUSTOMER_PHOTO_PATH . $foto_thumbnail;
        if (!empty($foto_thumbnail) && file_exists($foto_thumbnail_file)) {
            if ($this->hasFileAllowedExtension($foto_thumbnail, $a_extensions)) {
                //$x_tempfile = 'foto_' . $id_e . '.jpg';
                // het hoeft nog geen jpeg te zijn. daarom nu eerst maar de bestandsnaam overnemen
                $x_tempfile = $foto_thumbnail;
                copy($foto_thumbnail_file, ModuleUtils::getCustomerTempPath() . $x_tempfile);
                $displayable_photo = ModuleUtils::getCustomerTempUrl() . $x_tempfile;
                // omdat er soms te grote of te kleine foto's zijn hier de afmeting beperken
                list($file_width, $file_height) = getimagesize($foto_thumbnail_file);
                $file_width = min($file_width, DEFAULT_PHOTO_WIDTH);
                $file_height = min($file_height, DEFAULT_PHOTO_HEIGHT);
            }

        }
        //die('$displayable_photo'.$displayable_photo);
        return array($displayable_photo, $file_width, $file_height);
//        return $displayable_photo;

    }

    static function deletePhotoFile($photoFile)
    {
         try {
            if (!empty($photoFile)) {
                @unlink(CUSTOMER_PHOTO_PATH . $photoFile);
            }
        } catch (TimecodeException $ignore) {
            // bestond waarschijnlijk niet meer...
        }
    }

    static function getPhotoContent($contentId)
    {
        return @mysql_fetch_assoc(DocumentQueries::getDocumentContent($contentId));
    }

    static function getPhotoContentInfo($contentId)
    {
        return @mysql_fetch_assoc(DocumentQueries::getDocumentContentInfo($contentId));
    }


}

?>