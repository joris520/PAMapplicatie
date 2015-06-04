<?php

/**
 * Description of StandardDateController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/settings/StandardDateService.class.php');

class StandardDateController
{
    static function processEdit(StandardDateValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = StandardDateService::validate($valueObject);

        if (!$hasError) {
            StandardDateService::updateValidated($valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

}

?>
