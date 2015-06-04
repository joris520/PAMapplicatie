<?php

/**
 * Description of OrganisationInfoController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/organisation/OrganisationInfoService.class.php');

class OrganisationInfoController
{

    static function processEdit(OrganisationInfoValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = OrganisationInfoService::validate($valueObject);

        if (!$hasError) {
            OrganisationInfoService::updateValidated($valueObject);
            
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }
}

?>
