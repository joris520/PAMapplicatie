<?php


/**
 * Description of AssessmentProcessDashboardDetailView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardDetailValueObject.class.php');

class AssessmentProcessDashboardDetailView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/assessmentProcessDashboardDetailView.tpl';

    private $evaluationStateLabel;
    private $statusIconView;

    private $showEvaluationDetails;
    private $showSelectDetails;
    private $showCalculationDetails;
    private $showEvaluationStatusDetails;

    static function createWithValueObject(  AssessmentProcessDashboardDetailValueObject $valueObject,
                                            $displayWidth)
    {
        return new AssessmentProcessDashboardDetailView($valueObject,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setStatusIconView(AssessmentIconView $statusIconView)
    {
        $this->statusIconView = $statusIconView;
    }

    function getStatusIconView()
    {
        return $this->statusIconView;
    }

    function getStatusIconHtml()
    {
        return empty($this->statusIconView) ? '' : $this->statusIconView->fetchHtml();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEvaluationDetails($showEvaluationDetails)
    {
        $this->showEvaluationDetails = $showEvaluationDetails;
    }

    function showEvaluationDetails()
    {
        return $this->showEvaluationDetails;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEvaluationStatusDetails($showEvaluationStatusDetails)
    {
        $this->showEvaluationStatusDetails = $showEvaluationStatusDetails;
    }

    function showEvaluationStatusDetails()
    {
        return $this->showEvaluationStatusDetails;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowSelectDetails($showSelectDetails)
    {
        $this->showSelectDetails = $showSelectDetails;
    }

    function showSelectDetails()
    {
        return $this->showSelectDetails;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCalculationDetails($showCalculationDetails)
    {
        $this->showCalculationDetails = $showCalculationDetails;
    }

    function showCalculationDetails()
    {
        return $this->showCalculationDetails;
    }


}
?>
