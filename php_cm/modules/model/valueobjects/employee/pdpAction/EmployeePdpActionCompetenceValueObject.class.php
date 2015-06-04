<?php

/**
 * Description of EmployeePdpActionCompetenceValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeePdpActionCompetenceValueObject extends BaseEmployeeValueObject
{
    private $competenceName;

    private $employeePdpActionId;

    static function createWithData( $employeeId,
                                    $employeePdpActionId,
                                    $employeePdpActionCompetenceData)
    {
        return new EmployeePdpActionCompetenceValueObject(  $employeeId,
                                                            $employeePdpActionCompetenceData[EmployeePdpActionCompetenceQueries::ID_FIELD], // dus de competenceId
                                                            $employeePdpActionId,
                                                            $employeePdpActionCompetenceData);
    }

    protected function __construct( $employeeId,
                                    $competenceId,
                                    $employeePdpActionId,
                                    $employeePdpActionCompetenceData)
    {
        parent::__construct($employeeId,
                            $competenceId,
                            $employeePdpActionCompetenceData['saved_by_user_id'], // hebben we nog niet
                            $employeePdpActionCompetenceData['saved_by_user'],    // hebben we nog niet
                            $employeePdpActionCompetenceData['saved_datetime']);  // hebben we nog niet

        $this->employeePdpActionId  = $employeePdpActionId;

        // TODO: via competence queries?
        $this->competenceName       = $employeePdpActionCompetenceData['knowledge_skill_point'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCompetenceName()
    {
        return $this->competenceName;
    }
}

?>
