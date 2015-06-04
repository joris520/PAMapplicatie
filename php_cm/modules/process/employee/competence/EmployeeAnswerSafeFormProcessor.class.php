<?php

/**
 * Description of EmployeeScoreSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/QuestionService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceController.class.php');

class EmployeeAnswerSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {

            $employeeId = $safeFormHandler->retrieveSafeValue('employeeId');

            // ophalen vragen
            $questionValueObjects = QuestionService::getValueObjects(QuestionService::SHOW_ACTIVE);

            // ophalen ingevulde antwoorden
            // voor elke competentie de score ophalen en valideren
            $answerValueObjects = array();
            foreach ($questionValueObjects as $questionValueObject) {
                $questionId = $questionValueObject->getId();
                $employeeQuestionAnswer = $safeFormHandler->retrieveInputValue('question_answer_' . $questionId);

                $valueObject = EmployeeAnswerValueObject::createWithValues( $employeeId,
                                                                            $questionId,
                                                                            $questionValueObject->getQuestion(),
                                                                            $employeeQuestionAnswer);
                $answerValueObjects[] = $valueObject;
            }

            list($hasError, $messages) = EmployeeCompetenceController::processEditAnswers(  $employeeId,
                                                                                            $answerValueObjects);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditAnswer($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }


}

?>
