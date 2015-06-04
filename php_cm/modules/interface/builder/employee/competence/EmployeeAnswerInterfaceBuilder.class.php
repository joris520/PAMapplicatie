<?php

// components
require_once('modules/interface/builder/employee/competence/EmployeeAnswerInterfaceBuilderComponents.class.php');

// services
require_once('modules/model/service/library/QuestionService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAnswerService.class.php');

require_once('modules/model/valueobjects/library/AssessmentCycleValueObject.class.php');

// interface objects
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAnswerGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAnswerGroupEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAnswerView.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAnswerEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAnswerHistory.class.php');

class EmployeeAnswerInterfaceBuilder
{

    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeAnswerCollection $answerCollection)
    {
        $contentHtml = '';

        $answerValueObjects = $answerCollection->getValueObjects();

        if (count($answerValueObjects) > 0) {
            $groupInterfaceObject = EmployeeAnswerGroup::create($displayWidth);


            foreach ($answerValueObjects as $answerValueObject) {
                $interfaceObject = EmployeeAnswerView::createWithValueObject(   $answerValueObject,
                                                                                $displayWidth);

                $interfaceObject->setHistoryLink(   EmployeeAnswerInterfaceBuilderComponents::getHistoryLink(   $employeeId,
                                                                                                                $answerValueObject->getQuestionId()));
                $groupInterfaceObject->addInterfaceObject($interfaceObject);
            }

            // en dat alles in een blok laten zien
            $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                        TXT_UCF('ASSESSMENT_QUESTIONS'),
                                                                        $displayWidth);
            $blockInterfaceObject->addActionLink(   EmployeeAnswerInterfaceBuilderComponents::getEditLink($employeeId));

            $contentHtml = $blockInterfaceObject->fetchHtml();
        }

        return $contentHtml;
    }

    //// Question Answers
    static function getEditHtml($displayWidth,
                                $employeeId,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = '';

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_QUESTIONS_ANSWER);
        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->addPrefixStringInputFormatType('question_answer_');
        $safeFormHandler->finalizeDataDefinition();


        $groupInterfaceObject = EmployeeAnswerGroupEdit::create($displayWidth);

        // ophalen vragen info
        $questionValueObjects = QuestionService::getValueObjects(QuestionService::SHOW_ACTIVE);

        // ophalen antwoorden
        foreach ($questionValueObjects as $questionValueObject) {
            $questionId = $questionValueObject->getId();
            $answerValueObject = EmployeeAnswerService::getValueObject( $employeeId,
                                                                        $questionId,
                                                                        $assessmentCycle);
            $answerValueObject->setAssessmentQuestion(  $questionValueObject->getQuestion());


            $interfaceObject = EmployeeAnswerEdit::createWithValueObject(   $answerValueObject,
                                                                            $displayWidth);
            $answeredQuestion   = $answerValueObject->getAnsweredQuestion();
            $currentQuestion    = $questionValueObject->getQuestion();
            $interfaceObject->setDisplayQuestion(   !empty($currentQuestion) ? $currentQuestion : $answeredQuestion);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        $contentHtml = $groupInterfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }



    /// HISTORY
    static function getHistoryHtml( $displayWidth,
                                    $employeeId,
                                    $questionId)
    {
        $interfaceObject = EmployeeAnswerHistory::create($displayWidth);

        // ophalen answers
        $valueObjects = EmployeeAnswerService::getValueObjects( $employeeId,
                                                                $questionId);

        foreach ($valueObjects as $valueObject) {
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDateTime());

            $valueObject->setAssessmentCycleValueObject($historyPeriod);

            $interfaceObject->addValueObject($valueObject);
        }

        return $interfaceObject->fetchHtml();
    }

}

?>
