<?php

/**
 * Description of EmployeeCompetenceService
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceValueObject.class.php');
require_once('modules/model/queries/employee/competence/EmployeeCompetenceQueries.class.php');
require_once('modules/model/queries/library/CompetenceQueries.class.php');

// andere services
require_once('modules/model/service/library/QuestionService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAnswerService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentService.class.php');
require_once('modules/model/service/employee/competence/EmployeeJobProfileService.class.php');
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeSelfAssessmentScoreService.class.php');

require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceScoreCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeScoreCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceCategoryClusterScoreCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceClusterScoreCollection.class.php');
//require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceCategoryClusterScoreCollection.class.php');

class EmployeeCompetenceService
{
    const INCLUDE_360 = TRUE;
    const EXCLUDE_360 = FALSE;

    const FETCH_ALL_CLUSTERS = NULL;

    const RETURN_AS_FLAT_ARRAY = TRUE;
    const RETURN_AS_CATEGORY_CLUSTER_ARRAY = FALSE;

    // je eigen competentiescherm inzien: je mag alleen de scores van de manager zien als deze definitief zijn
    static function isAllowedViewManagerScore($employeeId, $scoreStatus)
    {
        $isAllowed = ($employeeId != EMPLOYEE_ID) ? TRUE : (CUSTOMER_OPTION_USE_SCORE_STATUS ? $scoreStatus == ScoreStatusValue::FINALIZED : TRUE);
        return $isAllowed;
    }

    static function isAllowedEditManagerScore($employeeId)
    {
        return ($employeeId != EMPLOYEE_ID) ? PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES) : FALSE;
    }

    static function isAllowedViewEmployeeScore($employeeId, $scoreStatus)
    {
        return ($employeeId == EMPLOYEE_ID) ? TRUE : (CUSTOMER_OPTION_USE_SCORE_STATUS ? $scoreStatus == ScoreStatusValue::FINALIZED : TRUE);
    }

    static function getCollection(  $employeeId,
                                    AssessmentCycleValueObject $currentPeriod,
                                    AssessmentCycleValueObject $previousPeriod)
    {
        $collection = EmployeeCompetenceCollection::create($currentPeriod, $previousPeriod);

        $collection->setEmployeeAssessmentEvaluationValueObject(    EmployeeAssessmentEvaluationService::getValueObject(    $employeeId, $currentPeriod));
        $collection->setEmployeeJobProfileValueObject(              EmployeeJobProfileService::getValueObject(              $employeeId, $currentPeriod->getEndDate()));

        $collection->setAssessmentCollections(  EmployeeAssessmentService::getCollection($employeeId, $currentPeriod),
                                                EmployeeAssessmentService::getCollection($employeeId, $previousPeriod));

        $employeeAssessmentValueObject          = EmployeeAssessmentService::getValueObject($employeeId, $currentPeriod);
        $previousEmployeeAssessmentValueObject  = EmployeeAssessmentService::getValueObject($employeeId, $previousPeriod);

        $collection->setEmployeeAssessmentValueObjects( $employeeAssessmentValueObject,
                                                        $previousEmployeeAssessmentValueObject);

        $employeeAnswerCollection = EmployeeAnswerService::getCollection($employeeId, $currentPeriod);
        $collection->setEmployeeAnswerCollection($employeeAnswerCollection);


        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // de collecties met competentie en scores ophalen...
        $include360 = CUSTOMER_OPTION_SHOW_360 ? self::INCLUDE_360 : self::EXCLUDE_360;

        $currentEmployeeScoreCollection     = self::getEmployeeCompetenceCategoryClusterScoreCollection($employeeId,
                                                                                                        $include360,
                                                                                                        $currentPeriod);
        $previousEmployeeScoreCollection    = self::getEmployeeCompetenceCategoryClusterScoreCollection($employeeId,
                                                                                                        $include360,
                                                                                                        $previousPeriod);

        // en aan CompetenceCollectie toevoegen
        $collection->setEmployeeCompetenceCategoryClusterScoreCollections(  $currentEmployeeScoreCollection,
                                                                            $previousEmployeeScoreCollection);

        return $collection;
    }

    function getEmployeeCompetenceCategoryClusterScoreCollection(   $employeeId,
                                                                    $include360,
                                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $employeeAssessmentValueObject  = EmployeeAssessmentService::getValueObject($employeeId, $assessmentCycle);
        $jobProfileValueObject          = EmployeeJobProfileService::getValueObject($employeeId);
        $competenceValueObjects         = self::getValueObjects($employeeId,
                                                                $jobProfileValueObject->getMainFunctionId(),
                                                                self::FETCH_ALL_CLUSTERS,
                                                                self::RETURN_AS_CATEGORY_CLUSTER_ARRAY);

        $scoreStatus = $employeeAssessmentValueObject->getScoreStatus();
        $assessmentDate = $employeeAssessmentValueObject->getAssessmentDate();

        // collectie per assessmentCycle
        $collection = EmployeeCompetenceCategoryClusterScoreCollection::create( $assessmentCycle,
                                                                                $jobProfileValueObject,
                                                                                $assessmentDate,
                                                                                $scoreStatus);

        $categoryIds = array_keys($competenceValueObjects);

        foreach($categoryIds as $categoryId) {
            $clusterIds = array_keys($competenceValueObjects[$categoryId]);

            foreach($clusterIds as $clusterId) {
                $clusterCompetenceValueObjects = $competenceValueObjects[$categoryId][$clusterId];
                $clusterScoreCollection = self::getClusterScoreCollection(  $employeeId,
                                                                            $clusterId,
                                                                            $include360,
                                                                            $assessmentCycle,
                                                                            $clusterCompetenceValueObjects);

                $categoryName = $clusterScoreCollection->getCategoryName();

                // en de collectie toevoegen
                $collection->addEmployeeClusterScoreCollection( $categoryId,
                                                                $categoryName,
                                                                $clusterId,
                                                                $clusterScoreCollection);
            }
        }
        return $collection;

    }

    function getEmployeeCompetenceClusterScoreCollection(   $employeeId,
                                                            $clusterId,
                                                            $include360,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $functionValueObject            = EmployeeJobProfileService::getValueObject($employeeId);
        $competenceValueObjects         = self::getValueObjects($employeeId,
                                                                $functionValueObject->getMainFunctionId(),
                                                                $clusterId);

        $clusterScoreCollection = self::getClusterScoreCollection(  $employeeId,
                                                                    $clusterId,
                                                                    $include360,
                                                                    $assessmentCycle,
                                                                    $competenceValueObjects);

        //die('$clusterScoreCollection'.print_r($clusterScoreCollection, true));
        return $clusterScoreCollection;
    }

    protected function getClusterScoreCollection(   $employeeId,
                                                    $clusterId,
                                                    $include360,
                                                    AssessmentCycleValueObject $assessmentCycle,
                                                    Array $competenceValueObjects)
    {
        $clusterScoreCollection = EmployeeCompetenceClusterScoreCollection::create( $clusterId,
                                                                                    $assessmentCycle);

        // per competentie de scores ophalen in de collection
        foreach($competenceValueObjects as $competenceValueObject) {
            $categoryName   = $competenceValueObject->getCategoryName();
            $clusterName    = $competenceValueObject->getClusterName();
            $competenceId   = $competenceValueObject->getCompetenceId();

            $clusterScoreCollection->setClusterName($clusterName);
            $clusterScoreCollection->setCategoryName($categoryName);


            // huidige score ophalen
            $valueObject = EmployeeScoreService::getValueObject($employeeId, $competenceId, $assessmentCycle);
            $valueObject->setAssessmentCycleValueObject($assessmentCycle);
            // in de collectie
            $employeeScoreCollection = EmployeeScoreCollection::create($competenceValueObject);
            $employeeScoreCollection->setScoreValueObject($valueObject);

            // valideren
            list($hasError) = EmployeeScoreService::validateScore(  $valueObject,
                                                                    $competenceValueObject->getCompetenceName(),
                                                                    $competenceValueObject->getCompetenceScaleType(),
                                                                    $competenceValueObject->getCompetenceIsOptional());

            $employeeScoreCollection->markIncompleteScore($hasError);
            if ($hasError) {
                $clusterScoreCollection->markClusterHasIncompleteScores();
            }

            if ($include360 == self::INCLUDE_360) {
                // zelfevaluatie ophalen
                $selfAssessmentScoreValueObject = EmployeeSelfAssessmentScoreService::getValueObject($employeeId, $competenceId, $assessmentCycle);
                $selfAssessmentScoreValueObject->setAssessmentCycleValueObject($assessmentCycle);

                // in de collectie
                $employeeScoreCollection->setSelfAssessmentScoreValueObject($selfAssessmentScoreValueObject);
            }

            // en de collectie toevoegen
            $clusterScoreCollection->addEmployeeScoreCollection($competenceId,
                                                                $employeeScoreCollection);
        }
        return $clusterScoreCollection;
    }


    function getEmployeeCompetenceScoreCollections( $employeeId,
                                                    AssessmentCycleValueObject $currentPeriod,
                                                    AssessmentCycleValueObject $previousPeriod)
    {
        $scoreCollections = array();

        $show360 = CUSTOMER_OPTION_SHOW_360;

        $employeeAssessmentValueObject          = EmployeeAssessmentService::getValueObject($employeeId, $currentPeriod);
        $previousEmployeeAssessmentValueObject  = EmployeeAssessmentService::getValueObject($employeeId, $previousPeriod);

        $functionValueObject = EmployeeJobProfileService::getValueObject($employeeId);
        $competenceValueObjects = EmployeeCompetenceService::getValueObjects($employeeId, $functionValueObject->getMainFunctionId());


        // per competentie de scores ophalen in de collection
        foreach($competenceValueObjects as $competenceValueObject) {
            $employeeCompetenceScoreCollection = EmployeeCompetenceScoreCollection::create( $competenceValueObject,
                                                                                            $currentPeriod,
                                                                                            $previousPeriod,
                                                                                            $employeeAssessmentValueObject->getScoreStatus(),
                                                                                            $previousEmployeeAssessmentValueObject->getScoreStatus());
            $competenceId   = $competenceValueObject->competenceId;

            // huidige score ophalen
            $valueObject = EmployeeScoreService::getValueObject($employeeId, $competenceId, $currentPeriod);
            $valueObject->setAssessmentCycleValueObject($currentPeriod);

            // valideren
            list($hasError) = EmployeeScoreService::validateScore(  $valueObject,
                                                                    $competenceValueObject->getCompetenceName(),
                                                                    $competenceValueObject->getCompetenceScaleType(),
                                                                    $competenceValueObject->getCompetenceIsOptional());
            if ($hasError) {
                $employeeCompetenceScoreCollection->markIncompleteScore();
            }

            // vorige score ophalen
            $previousValueObject = EmployeeScoreService::getValueObject($employeeId, $competenceId, $previousPeriod);
            $previousValueObject->setAssessmentCycleValueObject($previousPeriod);

            // in de collectie
            $employeeCompetenceScoreCollection->setEmployeeScoreValueObjects($valueObject, $previousValueObject);

            if ($show360) {
                // zelfevaluatie ophalen
                $selfAssessmentScoreValueObject = EmployeeSelfAssessmentScoreService::getValueObject($employeeId, $competenceId, $currentPeriod);
                $selfAssessmentScoreValueObject->setAssessmentCycleValueObject($currentPeriod);

                // vorige zelfevaluatie ophalen
                $previousSelfAssessmentScoreValueObject = EmployeeSelfAssessmentScoreService::getValueObject($employeeId, $competenceId, $previousPeriod);
                $previousSelfAssessmentScoreValueObject->setAssessmentCycleValueObject($previousPeriod);

                // in de collecti
                $employeeCompetenceScoreCollection->setEmployeeSelfAssessmentScoreValueObjects($selfAssessmentScoreValueObject, $previousSelfAssessmentScoreValueObject);
            }

            // en de collectie toevoegen
            $scoreCollections[] = $employeeCompetenceScoreCollection;
        }
        return $scoreCollections;

    }


    // Door de array_keys() van het array op te vragen krijg je alle competentie id's voor het ophalen van de scores (flat mode).
    static function getValueObjects($employeeId, $mainFunctionId, $clusterId = self::FETCH_ALL_CLUSTERS, $mode = self::RETURN_AS_FLAT_ARRAY) //nog geen periode voor functie: //, $periodStartDataTime = NULL, $referenceDateTime = REFERENCE_DATETIME)
    {
        $competenceValueObjects = array();
        $query = EmployeeCompetenceQueries::getFunctionModeCompetences($employeeId, $mainFunctionId, $clusterId); // filter op specifiek cluster
        while ($competenceData = @mysql_fetch_assoc($query)) {
            $valueObject = EmployeeCompetenceValueObject::createWithData($employeeId, $competenceData);
            if ($mode == self::RETURN_AS_CATEGORY_CLUSTER_ARRAY) {
                $categoryId = $valueObject->getCategoryId();
                $clusterId  = $valueObject->getClusterId();
//                if ($clusterId == self::FETCH_ALL_CLUSTERS) {
                    $competenceValueObjects[$categoryId][$clusterId][] = $valueObject;
//                } else {
//                    $competenceValueObjects[$clusterId][] = $valueObject;
//                }
            } else {
                $competenceValueObjects[] = $valueObject;
            }
        }

        mysql_free_result($query);
        return $competenceValueObjects;
    }

    static function getValueObjectById($employeeId, $competenceId) //nog geen periode voor competentie: //, $periodStartDataTime = NULL, $referenceDateTime = REFERENCE_DATETIME)
    {
        $query = CompetenceQueries::getCompetenceById($competenceId); // nog geen periode voor functie: //, $periodStartDataTime, $referenceDateTime);
        $competenceData = @mysql_fetch_assoc($query);
        $competenceValueObject = EmployeeCompetenceValueObject::createWithData($employeeId, $competenceData);

        mysql_free_result($query);
        return $competenceValueObject;
    }

//    static function getCompetenceInfo($competenceId)
//    {
//        $query = CompetenceQueriesDeprecated::getCompetenceDetails($competenceId);
//        $competenceInfo = @mysql_fetch_assoc($query);
//        mysql_free_result($query);
//        return $competenceInfo;
//    }

    static function validatePrintOptions( $showRemarks,
                                          $showThreesixty,
                                          $showPdpAction )
    {
        $hasError = false;
        $messages = array();


        if (!BooleanValue::isValidValue($showRemarks)) {
            $hasError = true;
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        }

        if (!BooleanValue::isValidValue($showThreesixty)) {
            $hasError = true;
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        }

        if (!BooleanValue::isValidValue($showPdpAction)) {
            $hasError = true;
            $messages[] = TXT_UCF('INVALID_PRINT_OPTION_VALUE');
        }

        return array($hasError, $messages);
    }


    static function hasCompleteScores(  $employeeId,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $hasCompleteScores = true;

        $jobProfileValueObject          = EmployeeJobProfileService::getValueObject($employeeId);
        $competenceValueObjects         = self::getValueObjects($employeeId,
                                                                $jobProfileValueObject->getMainFunctionId());

        foreach($competenceValueObjects as $competenceValueObject)
        {
            $employeeScore = EmployeeScoreService::getValueObject(  $employeeId,
                                                                    $competenceValueObject->getCompetenceId(),
                                                                    $assessmentCycle);
            if (!ScoreValue::isValidScore(  $employeeScore->getScore(),
                                            $competenceValueObject->getCompetenceScaleType(),
                                            $competenceValueObject->getCompetenceIsOptional() ?
                                                            BaseDatabaseValue::VALUE_OPTIONAL :
                                                            BaseDatabaseValue::VALUE_REQUIRED)) {
                $hasCompleteScores = false;
                break;
            }
        }
        return $hasCompleteScores;
    }
}

?>
