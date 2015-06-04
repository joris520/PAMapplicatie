<?php

/**
 * Description of LogoService
 *
 * @author ben.dokter
 */

require_once('application/model/service/CustomerService.class.php');
require_once('modules/model/service/upload/DocumentContentService.class.php');

class LogoService extends DocumentContentService
{
    static function placeLogoInCustomerFilePath($customerId)
    {
        // ophalen content...
        $valueObject = CustomerService::getInfoValueObject($customerId);
        list($logo, $dummyWidth, $dummyHeight, $contentId) = $valueObject->getLogoInfo();
        $logoFilePath = CustomerService::getCustomerLogoPath($customerId) . $logo;

        return self::copyContentToCustomerFilePath($customerId, $contentId, $logoFilePath);
    }
}

?>
