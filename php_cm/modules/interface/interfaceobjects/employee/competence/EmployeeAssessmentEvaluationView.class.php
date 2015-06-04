<?php


/**
 * Description of EmployeeAssessmentEvaluationView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentEvaluationView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentEvaluationView.tpl';

    private $attachmentLink;

    private $statusIconView;
    private $evaluationStateLabel;

    private $showEvaluationStatus;
    private $showEvaluationDate;
    private $showAttachmentLink;

    static function createWithValueObject(  EmployeeAssessmentEvaluationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAssessmentEvaluationView($valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAttachmentLink($attachmentLink)
    {
        $this->attachmentLink = $attachmentLink;
    }

    function getAttachmentLink()
    {
        return $this->attachmentLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowAttachmentLink($showAttachmentLink)
    {
        $this->showAttachmentLink = $showAttachmentLink;
    }

    function showAttachmentLink()
    {
        return $this->showAttachmentLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEvaluationDate($showEvaluationDate)
    {
        $this->showEvaluationDate = $showEvaluationDate;
    }

    function showEvaluationDate()
    {
        return $this->showEvaluationDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEvaluationStatus($showEvaluationStatus)
    {
        $this->showEvaluationStatus = $showEvaluationStatus;
    }

    function showEvaluationStatus()
    {
        return $this->showEvaluationStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEvaluationStateLabel($evaluationStateLabel)
    {
        $this->evaluationStateLabel = $evaluationStateLabel;
    }

    function getEvaluationStateLabel()
    {
        return $this->evaluationStateLabel;
    }

    //////////////////////////
    // iconView
    function setStatusIconView(AssessmentIconView $statusIconView)
    {
        $this->statusIconView = $statusIconView;
    }

    function getStatusIconHtml()
    {
        return !empty($this->statusIconView) ? $this->statusIconView->fetchHtml() : '';
    }

}

?>
