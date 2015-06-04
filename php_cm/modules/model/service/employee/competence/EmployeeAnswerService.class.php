<?php

/**
 * Description of EmployeeAnswerService
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAnswerCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAnswerValueObject.class.php');
require_once('modules/model/queries/employee/competence/EmployeeAnswerQueries.class.php');

class EmployeeAnswerService
{

    static function getCollection(  $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {

        $collection = EmployeeAnswerCollection::create();
        // vragen ophalen en antwoorden (42) zoeken
        $questionValueObjects = QuestionService::getValueObjects(QuestionService::SHOW_ACTIVE);

        foreach ($questionValueObjects as $questionValueObject) {
            $questionId = $questionValueObject->getId();
            $employeeAnswerValueObject = EmployeeAnswerService::getValueObject($employeeId, $questionId, $assessmentCycle);
            $employeeAnswerValueObject->setAssessmentQuestion($questionValueObject->getQuestion());

            $collection->addValueObject($employeeAnswerValueObject);
        }

        return $collection;
    }

    static function getValueObject( $employeeId,
                                    $questionId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeAnswerQueries::getAnswerInPeriod(  $employeeId,
                                                            $questionId,
                                                            $assessmentCycle->getStartDate(),
                                                            $assessmentCycle->getEndDate());
        $answerData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return EmployeeAnswerValueObject::createWithData(   $employeeId,
                                                            $questionId,
                                                            $answerData);
    }

    static function getValueObjects($employeeId, $questionId)
    {
        $valueObjects = array();

        $query = EmployeeAnswerQueries::selectAllAnswers($employeeId, $questionId);
        while ($answerData = mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeAnswerValueObject::createWithData($employeeId,
                                                                        $questionId,
                                                                        $answerData);
        }
        mysql_free_result($query);

        return $valueObjects;

    }

    static function validateAnswer(EmployeeAnswerValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        // geen specifieke check voor het antwoord
        if ($valueObject);

        return array($hasError, $messages);
    }

    static function updateValidated($employeeId, EmployeeAnswerValueObject $valueObject)
    {
        return EmployeeAnswerQueries::insertEmployeeAnswer( $employeeId,
                                                            $valueObject->getQuestionId(),
                                                            $valueObject->getAnsweredQuestion(),
                                                            $valueObject->getAnswer());
    }

}

?>
