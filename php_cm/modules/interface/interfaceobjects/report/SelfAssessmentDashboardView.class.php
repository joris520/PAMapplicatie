<?php

/**
 * Description of SelfAssessmentDashboardView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

require_once('modules/model/valueobjects/report/SelfAssessmentDashboardValueObject.class.php');

require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');
require_once('modules/model/value/employee/competence/ScoreStatusValue.class.php');

class SelfAssessmentDashboardView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentDashboardView.tpl';

    private $invitedDetailLink;
    private $employeeNotCompletedDetailLink;
    private $employeeCompletedDetailLink;
    private $bossNotCompletedDetailLink;
    private $bossCompletedDetailLink;
    private $bothCompletedDetailLink;

    static function create( SelfAssessmentDashboardValueObject $valueObject,
                            $displayWidth)
    {
        return new SelfAssessmentDashboardView( $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitedDetailLink($invitedDetailLink)
    {
        $this->invitedDetailLink = $invitedDetailLink;
    }

    function getInvitedDetailLink()
    {
        return $this->invitedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeNotCompletedDetailLink($employeeNotCompletedDetailLink)
    {
        $this->employeeNotCompletedDetailLink = $employeeNotCompletedDetailLink;
    }

    function getEmployeeNotCompletedDetailLink()
    {
        return $this->employeeNotCompletedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeCompletedDetailLink($employeeCompletedDetailLink)
    {
        $this->employeeCompletedDetailLink = $employeeCompletedDetailLink;
    }

    function getEmployeeCompletedDetailLink()
    {
        return $this->employeeCompletedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBossNotCompletedDetailLink($bossNotCompletedDetailLink)
    {
        $this->bossNotCompletedDetailLink = $bossNotCompletedDetailLink;
    }

    function getBossNotCompletedDetailLink()
    {
        return $this->bossNotCompletedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBossCompletedDetailLink($bossCompletedDetailLink)
    {
        $this->bossCompletedDetailLink = $bossCompletedDetailLink;
    }

    function getBossCompletedDetailLink()
    {
        return $this->bossCompletedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBothCompletedDetailLink($bothCompletedDetailLink)
    {
        $this->bothCompletedDetailLink = $bothCompletedDetailLink;
    }

    function getBothCompletedDetailLink()
    {
        return $this->bothCompletedDetailLink;
    }

}

?>
