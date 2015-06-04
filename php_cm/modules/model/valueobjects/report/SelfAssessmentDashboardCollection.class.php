<?php

/**
 * Description of SelfAssessmentDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/report/SelfAssessmentDashboardValueObject.class.php');

class SelfAssessmentDashboardCollection extends BaseCollection
{
    private $totalCountValueObject;

    static function create()
    {
        return new SelfAssessmentDashboardCollection();
    }

    protected function __construct()
    {
        parent::__construct();
        $this->totalCountValueObject = SelfAssessmentDashboardCountValueObject::create();
    }

    function addValueObject(SelfAssessmentDashboardValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
        // totalen bijwerken
        $this->totalCountValueObject->addInvitedTotal(          $valueObject->getInvitedTotal());

        $this->totalCountValueObject->addEmployeeNotCompleted(  $valueObject->getEmployeeNotCompleted());
        $this->totalCountValueObject->addEmployeeCompleted(     $valueObject->getEmployeeCompleted());
        $this->totalCountValueObject->addEmployeeDeleted(       $valueObject->getEmployeeDeleted());
        $this->totalCountValueObject->addBossNotCompleted(      $valueObject->getBossNotCompleted());
        $this->totalCountValueObject->addBossCompleted(         $valueObject->getBossCompleted());
        $this->totalCountValueObject->addBothCompleted(         $valueObject->getBothCompleted());

    }

    function getTotalCountValueObject()
    {
        return $this->totalCountValueObject;
    }

}

?>
