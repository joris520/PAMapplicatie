<?php

/**
 * Description of OrganisationInfoSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/organisation/OrganisationInfoController.class.php');

class OrganisationInfoSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages  = array();

        if (PermissionsService::isEditAllowed(PERMISSION_MENU_ORGANISATION)) {

            $infoText = $safeFormHandler->retrieveInputValue('company_info');

            $valueObject = OrganisationInfoValueObject::createWithValues(CUSTOMER_ID, $infoText);

            list($hasError, $messages) = OrganisationInfoController::processEdit($valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                OrganisationInfoInterfaceProcessor::finishEdit($objResponse);
            }
        }
        return array($hasError, $messages);
    }
}

?>
