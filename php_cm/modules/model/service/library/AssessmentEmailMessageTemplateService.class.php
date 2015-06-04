<?php

/**
 * Description of AssessmentEmailMessageTemplateService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/library/AssessmentEmailMessageTemplateQueries.class.php');
require_once('modules/model/valueobjects/library/AssessmentEmailMessageTemplateValueObject.class.php');

class AssessmentEmailMessageTemplateService
{

    // TODO: de tabel moet nog omgezet worden naar 1 met 2 velden....
    // voor het valueObject doen we nu net alsof dat zo is :-)

    static function getValueObject()
    {

        $valueObject = NULL;
        $query = AssessmentEmailMessageTemplateQueries::getNotificationMessages();

        $emailMessageInternalData = mysql_fetch_assoc($query);
        $internalMessage = $emailMessageInternalData['message'];
        $emailMessageExternalData = mysql_fetch_assoc($query);
        $externalMessage = $emailMessageExternalData['message'];
        mysql_free_result($query);

        $valueObject = AssessmentEmailMessageTemplateValueObject::createWithValues( NULL,
                                                                                    $internalMessage,
                                                                                    $externalMessage);

        return $valueObject;
    }

}

?>
