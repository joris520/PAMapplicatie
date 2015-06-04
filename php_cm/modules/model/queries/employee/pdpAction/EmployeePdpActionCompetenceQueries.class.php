<?php

/**
 * Description of EmployeePdpActionCompetenceQueries
 * De competenties gekoppeld aan een POP actie
 *
 * @author ben.dokter
 */

class EmployeePdpActionCompetenceQueries
{

    const ID_FIELD = 'ID_KSP';

    // TODO: via competenceService koppelen aan ksp
    static function getRelatedCompetences(  $i_employeeId,
                                            $i_employeePdpActionId)
    {
         $sql = 'SELECT
                    epasp.*,
                    ksp.knowledge_skill_point,
                    ksp.ID_KSP
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN employees_pdp_actions_skill_points epasp
                        ON epasp.ID_KSP_FID = ksp.ID_KSP
                WHERE
                    epasp.ID_E_FID = ' . $i_employeeId . '
                    AND epasp.ID_PDPEA_FID = ' . $i_employeePdpActionId . '
                ORDER BY
                    ksp.knowledge_skill_point';

         return BaseQueries::performSelectQuery($sql);
    }

}

?>
