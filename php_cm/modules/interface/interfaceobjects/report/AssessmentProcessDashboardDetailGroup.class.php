<?php

/**
 * Description of AssessmentProcessDashboardDetailGroup
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardDetailView.class.php');

class AssessmentProcessDashboardDetailGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/assessmentProcessDashboardDetailGroup.tpl';

    private $bossName;
    private $showEvaluationDetails;
    private $showSelectDetails;
    private $showCalculationDetails;
    private $showEvaluationStatusDetails;

    static function create( $bossName,
                            $displayWidth)
    {
        return new AssessmentProcessDashboardDetailGroup(   $bossName,
                                                            $displayWidth);
    }

    protected function __construct( $bossName,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->bossName = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(AssessmentProcessDashboardDetailView $interfaceObject)
    {
        $interfaceObject->setShowEvaluationDetails(         $this->showEvaluationDetails);
        $interfaceObject->setShowEvaluationStatusDetails(   $this->showEvaluationStatusDetails);
        $interfaceObject->setShowSelectDetails(             $this->showSelectDetails);
        $interfaceObject->setShowCalculationDetails(        $this->showCalculationDetails);

        parent::addInterfaceObject($interfaceObject);
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
