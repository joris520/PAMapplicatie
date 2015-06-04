<?php

/**
 * Description of DefaultDateService
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/settings/StandardDateValueObject.class.php');
require_once('modules/model/queries/settings/StandardDateQueries.class.php');

class StandardDateService
{
    static function getValueObject()
    {
        $valueObject = NULL;

        $query = StandardDateQueries::getStandardDate();
        $standardDateData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        $valueObject = StandardDateValueObject::createWithData(CUSTOMER_ID, $standardDateData);
        return $valueObject;
    }

    static function getDefaultDate()
    {
        $standardDateValueObject = self::getValueObject();
        // als de default date in het verleden ligt kunnen we beter vandaag teruggeven.
        return DateUtils::getMaxNowOrDate($standardDateValueObject->defaultEndDate);
    }

    static function validate(StandardDateValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        // TODO: mag niet leeg zijn
        if (empty($valueObject->defaultEndDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_DEFAULT_END_DATE') . "\n";
        }

        return array($hasError, $messages);
    }

    static function updateValidated(StandardDateValueObject $valueObject)
    {
        return StandardDateQueries::updateStandardDate($valueObject->defaultEndDate);
    }
}

?>
