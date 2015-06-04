<?php

/**
 * Description of SelfAssessmentDashboardDetailGroup
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardView.class.php');

class SelfAssessmentDashboardDetailGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentDashboardDetailGroup.tpl';

    private $showEmployeeStatus;
    private $showEmployeeCompleted;
    private $showBossStatus;
    private $showDetails;

    private $bossName;

    static function create( $bossName,
                            $displayWidth)
    {
        return new SelfAssessmentDashboardDetailGroup(  $bossName,
                                                        $displayWidth);
    }

    protected function __construct($bossName, $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->bossName = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(SelfAssessmentDashboardDetailView $interfaceObject)
    {
        $interfaceObject->setShowEmployeeStatus(    $this->showEmployeeStatus);
        $interfaceObject->setShowEmployeeCompleted( $this->showEmployeeCompleted);
        $interfaceObject->setShowBossStatus(        $this->showBossStatus);
        $interfaceObject->setShowDetails(           $this->showDetails);

        parent::addInterfaceObject($interfaceObject);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
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
