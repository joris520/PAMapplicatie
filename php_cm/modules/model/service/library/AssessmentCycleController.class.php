<?php

/**
 * Description of AssessmentCycleController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/AssessmentCycleService.class.php');

class AssessmentCycleController
{
    static function processAdd(AssessmentCycleValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = AssessmentCycleService::validate($valueObject);
        if (!$hasError) {
            $assessmentCycleId = AssessmentCycleService::addValidated($valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $assessmentCycleId);
    }

    static function processEdit($assessmentCycleId, $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = AssessmentCycleService::validate($valueObject);
        if (!$hasError) {
            AssessmentCycleService::updateValidated($assessmentCycleId, $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemove($assessmentCycleId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        AssessmentCycleService::remove($assessmentCycleId);

        BaseQueries::finishTransaction();

        return array($hasError, $messages);
    }
}

?>
