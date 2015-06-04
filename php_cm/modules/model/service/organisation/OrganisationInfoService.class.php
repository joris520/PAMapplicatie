<?php

/**
 * Description of OrganisationInfoService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/organisation/OrganisationInfoQueries.class.php');
require_once('modules/model/valueobjects/organisation/OrganisationInfoValueObject.class.php');

class OrganisationInfoService {

    static function getValueObject()
    {
        $valueObject = NULL;

        $query = OrganisationInfoQueries::getOrganisationInfo();
        $organisationInfoData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        $valueObject = OrganisationInfoValueObject::createWithData(CUSTOMER_ID, $organisationInfoData);
        return $valueObject;
    }

    static function validate(OrganisationInfoValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        // no specific validation
        if ($valueObject);

        return array($hasError, $messages);
    }

    static function updateValidated(OrganisationInfoValueObject $valueObject)
    {
        return OrganisationInfoQueries::updateOrganisationInfo($valueObject->infoText);
    }
}

?>
