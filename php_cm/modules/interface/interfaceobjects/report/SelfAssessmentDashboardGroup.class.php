<?php

/**
 * Description of SelfAssessmentDashboardGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardView.class.php');

class SelfAssessmentDashboardGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentDashboardGroup.tpl';

    private $totalCountValueObject;
    private $showTotals;

    private $invitedDetailLink;
    private $employeeNotCompletedDetailLink;
    private $employeeCompletedDetailLink;
    private $bossNotCompletedDetailLink;
    private $bossCompletedDetailLink;
    private $bothCompletedDetailLink;

    static function create( SelfAssessmentDashboardCountValueObject $valueObject,
                            $showTotals,
                            $displayWidth)
    {
        return new SelfAssessmentDashboardGroup($valueObject,
                                                $showTotals,
                                                $displayWidth);
    }

    protected function __construct( SelfAssessmentDashboardCountValueObject $valueObject,
                                    $showTotals,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->totalCountValueObject = $valueObject;
        $this->showTotals = $showTotals;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(SelfAssessmentDashboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showTotals()
    {
        return $this->showTotals;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getInvitedTotal()
    {
        return $this->totalCountValueObject->getInvitedTotal();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeNotCompleted()
    {
        return $this->totalCountValueObject->getEmployeeNotCompleted();
    }

    function getEmployeeCompleted()
    {
        return $this->totalCountValueObject->getEmployeeCompleted();
    }

    function getEmployeeDeleted()
    {
        return $this->totalCountValueObject->getEmployeeDeleted();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossNotCompleted()
    {
        return $this->totalCountValueObject->getBossNotCompleted();
    }

    function getBossCompleted()
    {
        return $this->totalCountValueObject->getBossCompleted();
    }

    function getBothCompleted()
    {
        return $this->totalCountValueObject->getBothCompleted();
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
