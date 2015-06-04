<?php

/**
 * Description of EmployeeAnswerView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAnswerView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAnswerView.tpl';

    private $historyLink;

    static function createWithValueObject(  EmployeeAnswerValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAnswerView(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    function displayEmployeeQuestion()
    {
        $answeredQuestion   = $this->valueObject->getAnsweredQuestion();
        $assessmentQuestion = $this->valueObject->getAssessmentQuestion();
        return empty($assessmentQuestion) ? $answeredQuestion : $assessmentQuestion;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHistoryLink($historyLink)
    {
        $this->historyLink = $historyLink;
        $this->addActionLink($historyLink);
    }

    function getHistoryLink()
    {
        return $this->historyLink;
    }


}

?>
