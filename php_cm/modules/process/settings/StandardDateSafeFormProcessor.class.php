<?php

/**
 * Description of StandardDateSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('modules/model/service/settings/StandardDateController.class.php');

class StandardDateSafeFormProcessor
{

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_DEFAULT_DATE)) {

            $defaultEndDate = $safeFormHandler->retrieveDateValue('default_end_date');

            $valueObject = StandardDateValueObject::createWithValues(CUSTOMER_ID, $defaultEndDate);

            list($hasError, $messages) = StandardDateController::processEdit($valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                StandardDateInterfaceProcessor::finishEdit($objResponse);
            }
        }
        return array($hasError, $messages);
    }


}

?>
