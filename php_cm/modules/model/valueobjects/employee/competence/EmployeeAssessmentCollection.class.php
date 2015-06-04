<?php

/**
 * Description of EmployeeAssessmentCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentEvaluationValueObject.class.php');
require_once('modules/model/valueobjects/assessmentInvitation/EmployeeSelfAssessmentInvitationValueObject.class.php');

class EmployeeAssessmentCollection extends BaseCollection
{

    private $assessmentValueObject;
    private $assessmentEvaluationValueObject;
    private $selfAssessmentInvitationValueObject;

    static function create( EmployeeAssessmentValueObject $assessmentValueObject,
                            EmployeeAssessmentEvaluationValueObject $assessmentEvaluationValueObject,
                            EmployeeSelfAssessmentInvitationValueObject $selfAssessmentInvitationValueObject)
    {
        return new EmployeeAssessmentCollection($assessmentValueObject,
                                                $assessmentEvaluationValueObject,
                                                $selfAssessmentInvitationValueObject);
    }

    protected function __construct( EmployeeAssessmentValueObject $assessmentValueObject,
                                    EmployeeAssessmentEvaluationValueObject $assessmentEvaluationValueObject,
                                    EmployeeSelfAssessmentInvitationValueObject $selfAssessmentInvitationValueObject)
    {
        parent::__construct();
        $this->assessmentValueObject = $assessmentValueObject;
        $this->assessmentEvaluationValueObject = $assessmentEvaluationValueObject;
        $this->selfAssessmentInvitationValueObject = $selfAssessmentInvitationValueObject;
    }

//    //////////////////////////////////////////////////////////////////////////////////////////////////////////
//    function $selfAssessmentInvitationValueObject()
//    {
//        return $this->$selfAssessmentInvitationValueObject();
//    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getScoreStatus()
    {
        return $this->assessmentValueObject->getScoreStatus();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEvaluationStatus()
    {
        return $this->assessmentEvaluationValueObject->getAssessmentEvaluationStatus();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isInvited()
    {
        return $this->selfAssessmentInvitationValueObject->isInvited();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getHashId()
    {
        return $this->selfAssessmentInvitationValueObject->getHashId();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isSent()
    {
        return $this->selfAssessmentInvitationValueObject->isSent();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCompleted()
    {
        return $this->selfAssessmentInvitationValueObject->getCompleted();
    }


}

?>
