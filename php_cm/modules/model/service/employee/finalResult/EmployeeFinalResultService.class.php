<?php

/**
 * Description of EmployeeFinalResultService
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/valueobjects/employee/finalResult/EmployeeFinalResultValueObject.class.php');
require_once('modules/model/valueobjects/employee/finalResult/EmployeeFinalResultPrintCollection.class.php');
require_once('modules/model/queries/employee/finalResult/EmployeeFinalResultQueries.class.php');
require_once('modules/print/option/EmployeeModuleDetailPrintOption.class.php');

class EmployeeFinalResultService
{

    const DETAIL_SCORES_VALIDATE    = TRUE;
    const DETAIL_SCORES_IGNORE      = FALSE;

    const TOTAL_SCORE_REQUIRED      = TRUE;
    const TOTAL_SCORE_OPTIONAL      = FALSE;

    const FINAL_RESULT_SCALE         = ScaleValue::SCALE_1_5;

    static function isAllowedDetailScores()
    {
        return CUSTOMER_OPTION_SHOW_FINAL_RESULT_DETAIL_SCORES;
    }

    static function getTotalScoreEditType()
    {
        return CUSTOMER_OPTION_TOTAL_SCORE_EDIT_TYPE;
    }

    static function getValidationLevel()
    {
        return EmployeeFinalResultService::isAllowedDetailScores() ? self::DETAIL_SCORES_VALIDATE : self::DETAIL_SCORES_IGNORE;
    }

    static function isAllowedEmptyTotalScore()
    {
        return (self::getTotalScoreEditType() == TotalScoreEditType::SELECT_LIST) ? self::TOTAL_SCORE_OPTIONAL : self::TOTAL_SCORE_REQUIRED;
    }



    static function getValueObject( $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = NULL;

        $query = EmployeeFinalResultQueries::getFinalResultInPeriod($employeeId,
                                                                    $assessmentCycle->getStartDate(),
                                                                    $assessmentCycle->getEndDate());
        $finalResultData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeFinalResultValueObject::createWithData($employeeId, $finalResultData);
        $valueObject->setAssessmentCycleValueObject($assessmentCycle);

        mysql_free_result($query);

        return $valueObject;
    }

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeeFinalResultQueries::selectFinalResults($employeeId);
        while ($finalResultData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeFinalResultValueObject::createWithData($employeeId, $finalResultData);
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function getValueObjectById($employeeId, $finalResultId)
    {
        $valueObject = NULL;

        $query = EmployeeFinalResultQueries::selectFinalResult($employeeId, $finalResultId);
        $finalResultData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeFinalResultValueObject::createWithData($employeeId, $finalResultData);
        mysql_free_result($query);

        return $valueObject;
    }

    static function getPrintCollection( $employeeId,
                                        AssessmentCycleValueObject $currentAssessmentCycleValueObject,
                                        $assessmentCycleOption)
    {
        $printCollection = EmployeeFinalResultPrintCollection::create();

        if ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE) {

            $valueObject = self::getValueObject($employeeId,
                                                $currentAssessmentCycleValueObject);

            $valueObject->setAssessmentCycleValueObject($currentAssessmentCycleValueObject);

            $printCollection->addValueObject($valueObject);

        } elseif ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_ALL_CYCLES) {
            // todo: niet helemaal ok, want er kan een eindbeoordeling buiten de boot vallen omdat deze voor de eerste cyclus ligt...

            $assessmentCycleValueObjects = AssessmentCycleService::getValueObjects();

            foreach($assessmentCycleValueObjects as $assessmentCycleValueObject) {
                $valueObject = self::getValueObject($employeeId,
                                                    $assessmentCycleValueObject);

                if ($valueObject->hasId()) {
                    $valueObject->setAssessmentCycleValueObject($assessmentCycleValueObject);
                    $printCollection->addValueObject($valueObject);
                }
            }
        }
        return $printCollection;
    }
    
    static function validate(EmployeeFinalResultValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $requiredState = self::isAllowedEmptyTotalScore() == self::TOTAL_SCORE_REQUIRED ?
                            BaseDatabaseValue::VALUE_REQUIRED :
                            BaseDatabaseValue::VALUE_OPTIONAL;

        $error_message = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES') . ' :' . '<br/>';

        // TODO: eigenlijk zijn alleen de scores met een ingevulde norm echt valide...
        if (!ScoreValue::isValidScore(  $valueObject->getTotalScore(),
                                        self::FINAL_RESULT_SCALE,
                                        $requiredState)) {
            $hasError = true;
            $error_message .= '- ' . TXT_UCF('TOTAL_RESULT') . '<br/>';
        }

        if (self::isAllowedDetailScores()) {
            if (!ScoreValue::isValidScore($valueObject->getBehaviourScore())) {
                $hasError = true;
                $error_message .= '- ' . TXT_UCF('BEHAVIOUR') . '<br/>';
            }

            if (!ScoreValue::isValidScore($valueObject->getResultsScore())) {
                $hasError = true;
                $error_message .= '- ' . TXT_UCF('RESULTS') . '<br/>';
            }
        }
        // alle niet valide scores melden
        if ($hasError) {
            $messages[] = $error_message;
        }


        $assessmentDate = $valueObject->getAssessmentDate();
        if (empty($assessmentDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE') . "\n";
        } else {
            // standaard controle op assessmentDate
            list($dateHasError, $dateMessages) = AssessmentCycleService::validateInCurrentAssessmentCycle($assessmentDate);
            $hasError = $hasError || $dateHasError;
            $messages = array_merge($messages, $dateMessages);
        }

        return array($hasError, $messages);
    }

    static function updateValidated($employeeId,
                                    EmployeeFinalResultValueObject $valueObject)
    {
        $storeTotalScore = $valueObject->getTotalScore() == ScoreValue::INPUT_SCORE_NA ? '' : $valueObject->getTotalScore();

        return EmployeeFinalResultQueries::insertFinalResult( $employeeId,
                                                            $valueObject->getAssessmentDate(),
                                                            $storeTotalScore,
                                                            $valueObject->getTotalScoreComment(),
                                                            $valueObject->getBehaviourScore(),
                                                            $valueObject->getBehaviourScoreComment(),
                                                            $valueObject->getResultsScore(),
                                                            $valueObject->getResultsScoreComment());
    }

    // TODO: naar de toekomstige "NormService"
    static function getTotalScoreIdValues()
    {
        $noAssessmentIdValue = array(IdValue::create(ScoreValue::INPUT_SCORE_NA, TXT_UCF('SCORE_NOT_ASSESSED')));
        $idScoreValues = ModuleUtils::getTotalScoreScaleIdValues(CUSTOMER_ID);
        return array_merge($noAssessmentIdValue, $idScoreValues);

    }

}

?>
