<?php

/**
 * Description of AssessmentIconCollection
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/assessmentInvitation/AssessmentInvitationInterfaceBuilderComponents.class.php');

class AssessmentIconCollection
{
    private $managerIconView;
    private $employeeIconView;
    private $assessmentCollection;

    static function create(EmployeeAssessmentCollection $assessmentCollection)
    {
        return new AssessmentIconCollection($assessmentCollection);
    }

    protected function __construct(EmployeeAssessmentCollection $assessmentCollection)
    {
        // score status icons
        list($managerTitle, $manangerIcon) = AssessmentInvitationInterfaceBuilderComponents::getScoreStatusDetails( $assessmentCollection->isInvited(),
                                                                                                                    $assessmentCollection->getScoreStatus());
        $this->managerIconView = AssessmentIconView::create($manangerIcon, $managerTitle);

        list($employeeTitle, $employeeIcon) = AssessmentInvitationInterfaceBuilderComponents::getSelfAssessmentDetails( $assessmentCollection->isInvited(),
                                                                                                                        $assessmentCollection->getCompleted());
        $this->employeeIconView = AssessmentIconView::create($employeeIcon, $employeeTitle);

        $this->assessmentCollection = $assessmentCollection;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getManagerIconView()
    {
        return $this->managerIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeIconView()
    {
        return $this->employeeIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentCollection()
    {
        return $this->assessmentCollection;
    }


}

?>
