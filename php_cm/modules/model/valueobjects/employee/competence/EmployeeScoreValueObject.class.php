<?php

/**
 * Description of EmployeeCompetenceScore
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceValueObject.class.php');

class EmployeeScoreValueObject extends BaseEmployeeValueObject
{
    // pas op, deze worden private. gebruik accessors
    var $competenceId;
    public $score;
    public $note;

    public $historyCompetenceName;
    public $historyClusterId;
    public $historyClusterName;
    public $historyClusterIsMain;
    public $historyNorm;
    public $historyFunctionId;
    public $historyFunction;

    public $migratie_ID_EPHD;
    public $migratie_ID_EPH;
    public $migratie_ID_ED;

    private $competenceValueObject;

    // factory method
    static function createWithData($employeeId, $competenceId, $employeeCompetenceScoreData)
    {
        return new EmployeeScoreValueObject($employeeId, $competenceId, $employeeCompetenceScoreData[EmployeeScoreQueries::ID_FIELD], $employeeCompetenceScoreData);
    }

    static function createWithValues($employeeId, $competenceId, $score, $note)
    {
        $employeeCompetenceScoreData = array();
        $employeeCompetenceScoreData['score'] = $score;
        $employeeCompetenceScoreData['note']  = $note;
        return new EmployeeScoreValueObject($employeeId, $competenceId, NULL, $employeeCompetenceScoreData);
    }

    function __construct($employeeId, $competenceId, $employeeCompetenceScoreId, $employeeCompetenceScoreData)
    {
        parent::__construct($employeeId,
                            $employeeCompetenceScoreId,
                            $employeeCompetenceScoreData['saved_by_user_id'],
                            $employeeCompetenceScoreData['saved_by_user'],
                            $employeeCompetenceScoreData['saved_datetime']);

        $this->competenceId             = $competenceId;

        $this->score                    = $employeeCompetenceScoreData['score'];
        $this->note                     = $employeeCompetenceScoreData['note'];

        $this->historyCompetenceName    = $employeeCompetenceScoreData['history_ksp_name'];
        $this->historyClusterId         = $employeeCompetenceScoreData['history_ID_C'];
        $this->historyClusterName       = $employeeCompetenceScoreData['history_cluster_name'];
        $this->historyClusterIsMain     = $employeeCompetenceScoreData['history_is_cluster_main'];
        $this->historyNorm              = $employeeCompetenceScoreData['history_norm'];
        $this->historyFunctionId        = $employeeCompetenceScoreData['history_ID_F'];
        $this->historyFunction          = $employeeCompetenceScoreData['history_function'];

        $this->migratie_ID_EPHD         = $employeeCompetenceScoreData['migratie_ID_EPHD'];
        $this->migratie_ID_EHP          = $employeeCompetenceScoreData['migratie_ID_EHP'];
        $this->migratie_ID_EP           = $employeeCompetenceScoreData['migratie_ID_EP'];
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceId
    function getCompetenceId()
    {
        return $this->competenceId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $score
    function setScore($score)
    {
        $this->score = $score;
    }

    function getScore()
    {
        return $this->score;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $note
    function setNote($note)
    {
        $this->note = $note;
    }

    function getNote()
    {
        return $this->note;
    }

    function hasNote()
    {
        return !empty($this->note);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyCompetenceName
    function getHistoryCompetenceName()
    {
        return $this->historyCompetenceName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyClusterId
    function getHistoryClusterId()
    {
        return $this->historyClusterId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyClusterName
    function getHistoryClusterName()
    {
        return $this->historyClusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyClusterIsMain
    function getHistoryClusterIsMain()
    {
        return $this->historyClusterIsMain;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyNorm
    function getHistoryNorm()
    {
        return $this->historyNorm;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyFunctionId
    function getHistoryFunctionId()
    {
        return $this->historyFunctionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $historyFunction
    function getHistoryFunction()
    {
        return $this->historyFunction;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceValueObject hulpje
    function setCompetenceValueObject(EmployeeCompetenceValueObject $competenceValueObject)
    {
        $this->competenceValueObject = $competenceValueObject;
    }

    function getCompetenceValueObject()
    {
        return $this->competenceValueObject;
    }


}

?>
