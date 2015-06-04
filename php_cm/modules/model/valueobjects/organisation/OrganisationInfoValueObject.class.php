<?php

/**
 * Description of OrganisationInfoValueObject
 *
 * @author ben.dokter
 */
require_once('application/model/valueobjects/BaseValueObject.class.php');

class OrganisationInfoValueObject extends BaseValueObject
{
    public $infoText;

    static function createWithData($organisationInfoId, $organisationInfoData)
    {

        return new OrganisationInfoValueObject($organisationInfoId, $organisationInfoData);
    }

    static function createWithValues($organisationInfoId, $infoText)
    {
        $organisationInfoData = array();

        $organisationInfoData[OrganisationInfoQueries::ID_FIELD] = $organisationInfoId;
        $organisationInfoData['info_text'] = $infoText;

        return new OrganisationInfoValueObject($organisationInfoId, $organisationInfoData);
    }

    function __construct($organisationInfoId, $organisationInfoData)
    {
        parent::__construct($organisationInfoId,
                            $organisationInfoData['saved_by_user_id'],
                            $organisationInfoData['saved_by_user'],
                            $organisationInfoData['saved_datetime']);

        $this->infoText = $organisationInfoData['info_text'];
    }
}

?>
