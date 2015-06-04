<?php
/**
 * Description of LogoContent
 *
 * @author ben.dokter
 */

require_once('application/model/service/CustomerService.class.php');
require_once('modules/model/service/upload/LogoService.class.php');
require_once('modules/model/service/upload/FileContent.class.php');
require_once('modules/model/queries/upload/LogoQueries.class.php');
require_once('gino/ImageUtils.class.php');


class LogoContent extends FileContent {

    var $logo_width = 0;
    var $logo_height = 0;


    function copyDBLogoToCustomerLogoPath($customerId)
    {
        LogoService::placeLogoInCustomerFilePath($customerId);
    }

    // hbd: todo: hier schaalspul inzetten
    // en weer kopieren naar user_logo
    function processFileContent($tempfile_name, $upload_mime, $document_name, $document_extension)
    {

        $this->message = TXT_UCF('LOGO_SELECTED');
        list($file_width, $file_height) = ImageUtils::getImageSizeFromFile($tempfile_name);
        list($logo_width, $logo_height, $hor_offset, $vert_offset) = ImageUtils::calculateLogoSize($file_width, $file_height, MAX_LOGO_WIDTH, MAX_LOGO_HEIGHT);

        $simg = ImageUtils::getImageInMemory($tempfile_name, $upload_mime);
        if (isset($simg)) {
            $newImage = ImageUtils::rescaleImage($simg, $file_width, $file_height, $logo_width, $logo_height,  $logo_width, $logo_height, $hor_offset, $vert_offset);
            $this->logo_width = $logo_width;
            $this->logo_height = $logo_height;
            $document_extension = 'jpg'; // we maken altijd een jpeg in memory
            //$this->local_name = 'customer_logo.jpg';
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
        return MAX_LOGO_BYTESIZE;
    }

    function getMaxUploadFileSizeLabel()
    {
        return ($this->getMaxUploadFileSize()/1024) . ' kB';
    }

    function processSetLogo()
    {
        $hasError = $this->uploadAndProcessFile();
        $alertTxt = $this->message;
        return array($hasError, $alertTxt);
    }

    function getCustomerPrintableLogo($customer_logo, $customer_logo_width, $customer_logo_height)
    {
        return $this->getCustomerValidLogo($customer_logo, $customer_logo_width, $customer_logo_height, GET_FILE_WITH_PATH, array('.jpg'));
    }

    function getCustomerDisplayableLogo($customer_logo, $customer_logo_width, $customer_logo_height)
    {
        return $this->getCustomerValidLogo($customer_logo, $customer_logo_width, $customer_logo_height, GET_FILE_WITH_URL, $this->getAllowedUploadExtensions());
    }

    function getCustomerValidLogo($customer_logo, $customer_logo_width, $customer_logo_height, $path_type, $a_extensions)
    {
        $is_default_logo = true;
        $displayable_logo = '';
        $customer_logo_file = '';
        $logo_width = DEFAULT_LOGO_WIDTH;
        $logo_height = DEFAULT_LOGO_HEIGHT;
        if (!empty($customer_logo) && $this->hasFileAllowedExtension($customer_logo, $a_extensions)) {
            $customer_logo_file = CUSTOMER_LOGO_PATH . $customer_logo;
            if (file_exists($customer_logo_file)) {
                $is_default_logo = false;
                $displayable_logo = CUSTOMER_LOGO_URL . $customer_logo;
                $printable_logo = $customer_logo_file;
                // omdat er soms te grote of te kleine foto's zijn hier de afmeting beperken
                if (!$customer_logo_width || !$customer_logo_height) {
                    list($customer_logo_width, $customer_logo_height) = getimagesize($customer_logo_file);
                }
                $logo_width = min($customer_logo_width, MAX_LOGO_WIDTH);
                $logo_height = min($customer_logo_height, MAX_LOGO_HEIGHT);
            }
        } else {
            $displayable_logo = APPLICATION_DEFAULT_LOGO_FILE_URL;
            $printable_logo = APPLICATION_DEFAULT_LOGO_FILE_PATH;
        }

        if ($path_type == GET_FILE_WITH_URL) {
            $return_logo = $displayable_logo;
        } else {
            $return_logo = $printable_logo;
        }
        return array($return_logo, $logo_width, $logo_height, $is_default_logo);
    }

}

?>
