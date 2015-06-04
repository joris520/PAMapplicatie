<?php

/**
 * Description of SelfAssessmentDashboardDetailView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

require_once('modules/model/valueobjects/report/SelfAssessmentReportInvitationValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentValueObject.class.php');


class SelfAssessmentDashboardDetailView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentDashboardDetailView.tpl';

    private $assessmentValueObject;

    private $showEmployeeStatus;
    private $showEmployeeCompleted;
    private $showBossStatus;
    private $showDetails;

    static function createWithValueObject(  SelfAssessmentReportInvitationValueObject $valueObject,
                                            EmployeeAssessmentValueObject   $assessmentValueObject,
                                            $displayWidth)
    {
        return new SelfAssessmentDashboardDetailView(   $valueObject,
                                                        $assessmentValueObject,
                                                        $displayWidth);
    }

    protected function __construct( SelfAssessmentReportInvitationValueObject $valueObject,
                                    EmployeeAssessmentValueObject   $assessmentValueObject,
                                    $displayWidth)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        $this->assessmentValueObject = $assessmentValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentValueObject()
    {
        return $this->assessmentValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEmployeeStatus($showEmployeeStatus)
    {
        $this->showEmployeeStatus = $showEmployeeStatus;
    }

    function showEmployeeStatus()
    {
        return $this->showEmployeeStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowEmployeeCompleted($showEmployeeCompleted)
    {
        $this->showEmployeeCompleted = $showEmployeeCompleted;
    }

    function showEmployeeCompleted()
    {
        return $this->showEmployeeCompleted;

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowBossStatus($showBossStatus)
    {
        $this->showBossStatus = $showBossStatus;
    }

    function showBossStatus()
    {
        return $this->showBossStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowDetails($showDetails)
    {
        $this->showDetails = $showDetails;
    }

    function showDetails()
    {
        return $this->showDetails;
    }

}

?>
