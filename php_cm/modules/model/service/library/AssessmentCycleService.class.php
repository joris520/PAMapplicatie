<?php

require_once('modules/model/queries/library/AssessmentCycleQueries.class.php');
require_once('modules/model/valueobjects/library/AssessmentCycleValueObject.class.php');
require_once('application/model/valueobjects/BaseValueObject.class.php');
require_once('application/interface/converter/DateConverter.class.php');

class AssessmentCycleService
{
    const EMPTY_END_DATE = DateUtils::MAX_DATE;

    const MODE_DATABASE = 1;
    const MODE_REPORT   = 2;

    const REPORT_USER_PERIOD_ID = -1;

    static function getValueObjects($limitNumber = NULL)
    {
        $valueObjects = array();

        $lastDate = self::EMPTY_END_DATE;
        $query = AssessmentCycleQueries::getAssessmentCycles($limitNumber);
        while ($assessmentCyclesData = mysql_fetch_assoc($query)) {
            $valueObject = AssessmentCycleValueObject::createWithData($assessmentCyclesData, $lastDate);
            $lastDate = $valueObject->getStartDate();
            $valueObjects[] = $valueObject;
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function getCurrentValueObject($today = NULL)
    {
        $today = empty($today) ? REFERENCE_DATE : $today;
        list($assessmentCycleData, $endDate) = self::getAssessmentCycleForDate($today);
        return AssessmentCycleValueObject::createWithData($assessmentCycleData, $endDate);
    }

    static function getPreviousValueObject($beforeDate)
    {
        list($assessmentCycleData, $beforeDate) = self::getAssessmentCycleBeforeDate($beforeDate);
        return AssessmentCycleValueObject::createWithData($assessmentCycleData, $beforeDate);
    }

    static function getValueObject($assessmentCycleId)
    {
        if ($assessmentCycleId == self::REPORT_USER_PERIOD_ID) {
            $startDate  = BaseReportService::retrieveAssessmentCycleStartDate(BaseReportService::SESSION_STORE__STORE_NAME);
            $endDate    = BaseReportService::retrieveAssessmentCycleEndDate(BaseReportService::SESSION_STORE__STORE_NAME);

            if (!empty($startDate) && !empty($endDate)) {
                $valueObject = AssessmentCycleValueObject::createWithValues(self::REPORT_USER_PERIOD_ID,
                                                                            TXT_UCF('USER_DEFINED_REPORT_PERIOD'),
                                                                            $startDate,
                                                                            $endDate);
            } else {
                $valueObject = self::getCurrentValueObject();
            }

        } else {
            $query = AssessmentCycleQueries::selectAssessmentCycle($assessmentCycleId);
            $assessmentCycleData = mysql_fetch_assoc($query);
            mysql_free_result($query);
            $referenceValueObject = AssessmentCycleValueObject::createWithData($assessmentCycleData);
            $valueObject = self::getCurrentValueObject($referenceValueObject->getStartDate());
        }
        return $valueObject;
    }

    static function getReportUserAssessmentCycleIdValue()
    {
        return IdValue::create( self::REPORT_USER_PERIOD_ID,
                                TXT_UCF('DEFINE_REPORT_PERIOD'));
    }

    static function getIdValues($mode = self::MODE_DATABASE)
    {
        $valueObjects = self::getValueObjects();

        $idValues = array();
        if ($mode == self::MODE_REPORT) {
            $idValues[-1] = self::getReportUserAssessmentCycleIdValue();
        }
        foreach($valueObjects as $valueObject) {
            $assessmentCycleId = $valueObject->getId();
            $idValues[$assessmentCycleId] = IdValue::create($assessmentCycleId,
                                                            $valueObject->getAssessmentCycleName());
        }
        return $idValues;
    }

    static function getAssessmentCycleForDate($databaseDate)
    {
        $query = AssessmentCycleQueries::findAssessmentCycleForDate($databaseDate);

        $currentAssessmentCycleData = NULL;
        $previousAssessmentCycleData = NULL;

        $assessmentCycleForDate = NULL;
        $assessmentCycleEndDate = NULL;
        while ($assessmentCyclesData = @mysql_fetch_assoc($query)) {
            switch($assessmentCyclesData['currentRecord']) {
                case 0:
                    $previousAssessmentCycleData    = $assessmentCyclesData;
                    break;
                case 1:
                    $currentAssessmentCycleData     = $assessmentCyclesData;
                    break;
            }
        }
        mysql_free_result($query);

        $assessmentCycleForDate = $currentAssessmentCycleData;
        $assessmentCycleEndDate = $previousAssessmentCycleData['start_date'];
        return array($assessmentCycleForDate, empty($assessmentCycleEndDate) ? self::EMPTY_END_DATE : $assessmentCycleEndDate);
    }

    static function getAssessmentCycleBeforeDate($databaseDate)
    {
        $query = AssessmentCycleQueries::findAssessmentCycleBeforeDate($databaseDate);
        $assessmentCycleForDate = @mysql_fetch_assoc($query);
        $assessmentCycleEndDate = $databaseDate;
        mysql_free_result($query);
        return array($assessmentCycleForDate, $assessmentCycleEndDate);
    }

    static function getAssessmentCycleIdWithStartDate($startDate)
    {
        $query = AssessmentCycleQueries::findAssessmentCycleWithStartDate($startDate);
        $assessmentCycle = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $assessmentCycle[AssessmentCycleQueries::ID_FIELD];
    }

    static function getAssessmentCycleIdWithName($cycleName)
    {
        $query = AssessmentCycleQueries::findAssessmentCycleWithName($cycleName);
        $assessmentCycle = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $assessmentCycle[AssessmentCycleQueries::ID_FIELD];
    }

    static function validateInCurrentAssessmentCycle($validateDate)
    {
        $hasError = false;
        $messages = array();

        $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();
        if (DateUtils::isBeforeDate($validateDate, REFERENCE_DATE)) {
            $hasError = true;
            $messages[] = TXT_UCF('ASSESSMENT_DATE_CANNOT_GREATER_THAN_TODAY');
        }

        if (DateUtils::isBeforeDate($currentAssessmentCycle->getStartDate(), $validateDate)) {
            $hasError = true;
            $messages[] = TXT_UCF_VALUE('ASSESSMENT_DATE_CANNOT_BE_BEFORE_THE_CURRENT_ASSESSMENT_CYCLE',
                                        array(DateConverter::display($currentAssessmentCycle->getStartDate())),
                                        array('%DATE%'));
        }
        return array($hasError, $messages);
    }

    // standaard controle op assessmentDate
    static function validateAssessmentDate($assessmentDate)
    {
        $hasError = false;
        $messages = array();

        if (empty($assessmentDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE') . "\n";
        } else {
            list($hasError, $messages) = self::validateInCurrentAssessmentCycle($assessmentDate);
        }
        return array($hasError, $messages);
    }

    static function validate(AssessmentCycleValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $assessmentCycleId = $valueObject->getId();
        $cycleName         = $valueObject->getAssessmentCycleName();
        $startDate         = $valueObject->getStartDate();

        if (empty($cycleName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_ASSESSMENT_CYCLE_NAME');
        } else {
            $foundId = self::getAssessmentCycleIdWithName($cycleName);
            if (!empty($foundId) && (empty($assessmentCycleId) || $assessmentCycleId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('NAME_ALREADY_EXISTS_FOR_ANOTHER_ASSESSMENT_CYCLE');
            }
        }
        if (empty($startDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_START_DATE');
        } else {
            $foundId = self::getAssessmentCycleIdWithStartDate($startDate);
            if (!empty($foundId) && (empty($assessmentCycleId) || $assessmentCycleId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('DATE_ALREADY_EXISTS_FOR_ANOTHER_ASSESSMENT_CYCLE');
            }
        }
        return array($hasError, $messages);
    }

    static function addValidated(AssessmentCycleValueObject $valueObject)
    {
        return AssessmentCycleQueries::insertAssessmentCycle(   $valueObject->getAssessmentCycleName(),
                                                                $valueObject->getStartDate());
    }

    static function updateValidated($assessmentCycleId,
                                    AssessmentCycleValueObject $valueObject)
    {
        return AssessmentCycleQueries::updateAssessmentCycle(   $assessmentCycleId,
                                                                $valueObject->getAssessmentCycleName(),
                                                                $valueObject->getStartDate());
    }

    static function remove($assessmentCycleId)
    {
        return AssessmentCycleQueries::deactivateAssessmentCycle($assessmentCycleId);
    }


}

?>
