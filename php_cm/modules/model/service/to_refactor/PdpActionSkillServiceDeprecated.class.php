<?php

class PdpActionSkillServiceDeprecated {


    const SKILL_INPUT_ID = 'kspid_';

//    static function getOpenActions($employee_id)
//    {
//
//        $employee_skill_actions_qry = sprintf("SELECT
//                                                    epa.action,
//                                                    epa.ID_PDPEA,
//                                                    epa.ID_E,
//                                                    epa.is_completed,
//                                                    epa.start_date,
//                                                    epa.end_date,
//                                                    ksp.knowledge_skill_point skill_name
//                                               FROM
//                                                    employees_pdp_actions epa
//                                                    INNER JOIN pdp_actions pa
//                                                               ON epa.ID_PDPAID = pa.ID_PDPA
//                                                    INNER JOIN employees_pdp_actions_skill_points epasp
//                                                               ON epa.ID_PDPEA = epasp.ID_PDPEA_FID
//                                                               AND epasp.ID_E_FID = '%s'
//                                                    LEFT JOIN knowledge_skills_points ksp
//                                                              ON ksp.ID_KSP = epasp.ID_KSP_FID
//                                                              AND epasp.ID_KSP_FID = '%s'
//                                                    ORDER BY UPPER(pa.action)",
//                                               mysql_real_escape_string($employee_id),
//                                               mysql_real_escape_string($id_ksp));
//
//        $employee_skill_actions_data = mysql_query($employee_skill_actions_qry) or die(mysql_error());
//
//        $actions = array();
//        if (@mysql_num_rows($employee_skill_actions_data) > 0) {
//            while ($employee_skill_action = @mysql_fetch_assoc($employee_skill_actions_data)) {
//                $skill_action = array();
//                $skill_action[ID_E]         = $employee_id;
//                $skill_action[ID_KSP]       = $id_ksp;
//                $skill_action[action_name]  = $employee_skill_action[action];
//                $skill_action[ID_PDPEA]     = $employee_skill_action[ID_PDPEA];
//                $skill_action[is_completed] = $employee_skill_action[is_completed];
//                $skill_action[start_date]   = $employee_skill_action[start_date];
//                $skill_action[end_date]     = $employee_skill_action[end_date];
//                $actions[] = $skill_action;
//            }
//        }
//
//        return $actions;
//    }

    static function getActionsBySkills($employee_id, $id_ksp)
    {

        $sql = 'SELECT
                    epa.action,
                    epa.ID_PDPEA,
                    epa.ID_E,
                    epa.is_completed,
                    epa.start_date,
                    epa.end_date
                FROM
                    employees_pdp_actions epa
                    INNER JOIN employees_pdp_actions_skill_points epasp
                        ON epa.ID_PDPEA = epasp.ID_PDPEA_FID
                            AND epasp.ID_KSP_FID = ' . mysql_real_escape_string($id_ksp) .'
                            AND epasp.ID_E_FID = ' . mysql_real_escape_string($employee_id) . '
                ORDER BY
                    UPPER(epa.action)';
        $employee_skill_actions_qry = BaseQueries::performQuery($sql);

        $actions = array();
        if (@mysql_num_rows($employee_skill_actions_qry) > 0) {
            while ($employee_skill_action = @mysql_fetch_assoc($employee_skill_actions_qry)) {
                $skill_action = array();
                $skill_action['ID_E']         = $employee_id;
                $skill_action['ID_KSP']       = $id_ksp;
                $skill_action['action_name']  = $employee_skill_action['action'];
                $skill_action['ID_PDPEA']     = $employee_skill_action['ID_PDPEA'];
                $skill_action['is_completed'] = $employee_skill_action['is_completed'];
                $skill_action['start_date']   = $employee_skill_action['start_date'];
                $skill_action['end_date']     = $employee_skill_action['end_date'];
                $actions[] = $skill_action;
            }
        }

        return $actions;
    }


    static function getSkillsByAction($employee_id, $id_pdpea)
    {
         $filter_action_qry = empty($id_pdpea) ? '' : ' AND epasp.ID_PDPEA_FID = ' . $id_pdpea;

         $sql = 'SELECT
                    ksp.knowledge_skill_point,
                    ksp.ID_KSP
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN employees_pdp_actions_skill_points epasp
                        ON epasp.ID_KSP_FID = ksp.ID_KSP
                            ' . $filter_action_qry . '
                            AND epasp.ID_E_FID = ' . $employee_id . '
                ORDER BY
                    UPPER(ksp.knowledge_skill_point)';

        $employee_action_skills_qry = BaseQueries::performQuery($sql);

        $skills = array();
        if (@mysql_num_rows($employee_action_skills_qry) > 0) {
            while ($employee_action_skill = @mysql_fetch_assoc($employee_action_skills_qry)) {
                $skill_action = array();
                $skill_action['skill_name'] = $employee_action_skill['knowledge_skill_point'];
                $skill_action['ID_KSP']     = $employee_action_skill['ID_KSP'];
                $skills[] = $skill_action;
            }
        }
        return $skills;
    }

    //$id_pdpea is edit actie id of null bij nieuwe actie
    static function getEmployeeScoredSkills($employee_id, $id_pdpea)
    {
        // ophalen gescoorde skills, en gekoppelde actie
        // todo: controle employees_pdp_actions.ID_E ?
        $filter_action_qry = (!empty($id_pdpea)) ? ' OR epasp.ID_PDPEA_FID  = '. $id_pdpea : ' ';
        $sql = 'SELECT
                    ks.knowledge_skill,
                    CASE WHEN ksc.cluster is null
                         THEN "zzzz"
                         ELSE ksc.cluster
                    END as clustername,
                    ep.ID_EP epid,
                    ep.scale employee_score,
                    ksc.ID_C clusterid,
                    ksp.knowledge_skill_point skill_name,
                    ksp.ID_KSP skillid,
                    epasp.ID_PDPEA_FID pdpactionid
                FROM
                    employees_points ep
                    INNER JOIN knowledge_skills_points ksp
                        ON ep.ID_KSP = ksp.ID_KSP
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksp.ID_C = ksc.ID_C
                    LEFT JOIN employees_pdp_actions_skill_points epasp
                        ON epasp.ID_KSP_FID = ksp.ID_KSP
                            AND (   epasp.ID_PDPEA_FID is NULL
                                    ' . $filter_action_qry . ' )
                WHERE
                    ep.ID_E = ' . $employee_id . '
                ORDER BY
                    UPPER(ks.knowledge_skill),
                    UPPER(clustername),
                    UPPER(skill_name),
                    skillid,
                    pdpactionid';

        $employee_scored_skills_qry = BaseQueries::performQuery($sql);

        $scored_skills = array();
        while ($employee_scored_skill = @mysql_fetch_assoc($employee_scored_skills_qry)) {
            $scored_skill = array();
            $scored_skill['knowledge_skill']         = CategoryConverter::display($employee_scored_skill['knowledge_skill']);
            $scored_skill['cluster_id']              = $employee_scored_skill['clusterid'];
            $scored_skill['cluster_name']            = ($employee_scored_skill['clustername'] == 'zzzz') ? '-' : $employee_scored_skill['clustername'];
            $scored_skill['skill_id']                = $employee_scored_skill['skillid'];
            $scored_skill['skill_name']              = $employee_scored_skill['skill_name'];
            $scored_skill['employee_point_id']       = $employee_scored_skill['epid'];
            $scored_skill['employee_point_input_id'] = PdpActionSkillServiceDeprecated::SKILL_INPUT_ID . $scored_skill['skill_id'];
            $scored_skill['employee_score']          = $employee_scored_skill['employee_score'];
//            $scored_skill['skill_norm']              = $employee_scored_skill['skill_norm'];
            $scored_skill['connected_action_id']     = $employee_scored_skill['pdpactionid'];
            $scored_skill['isConnected']             = (!empty($id_pdpea)) ? ($employee_scored_skill['pdpactionid'] == $id_pdpea) : false;

            $scored_skills[]=$scored_skill;
        }
        return $scored_skills;
    }

    // $available_skills IDs_AVAIL_SKILLS
    // $prev_selected_skills IDs_PREV_SKILLS
    static function processActionSkills($id_pdpea, $id_e, $safeFormHandler)
    {

    //    IDs_AVAIL_SKILLS: alle competentie Id's
        $available_skills = $safeFormHandler->retrieveSafeValue('IDs_AVAIL_SKILLS');
        // oude opruimen...
        if (! empty($id_pdpea)) {
            $sql = 'DELETE
                    FROM
                        employees_pdp_actions_skill_points
                    WHERE
                        ID_PDPEA_FID = ' . $id_pdpea;
            BaseQueries::performDeleteQuery($sql);
        }

        $available_skills_array = $available_skills;
        if (!empty($available_skills_array)) {
            foreach ($available_skills_array as $available_skill) {
                if (!empty($available_skill)) {
                    $selected_skill = $safeFormHandler->retrieveInputValue(PdpActionSkillServiceDeprecated::SKILL_INPUT_ID . $available_skill);
                    if ($selected_skill == 'on') {
                        $sql = 'INSERT INTO
                                    employees_pdp_actions_skill_points
                                    (   ID_E_FID,
                                        ID_PDPEA_FID,
                                        ID_KSP_FID
                                    ) VALUES (
                                        ' . $id_e . ',
                                        ' . $id_pdpea . ',
                                        ' . $available_skill . '
                                    )';

                        BaseQueries::performInsertQuery($sql);
                    }
                }
            }
        }
    }

    static function deletePdpActionSkills($id_pdpea)
    {
        if (! empty ($id_pdpea)) {
            $sql = 'DELETE
                    FROM
                        employees_pdp_actions_skill_points
                    WHERE
                        ID_PDPEA_FID = ' . $id_pdpea;
            BaseQueries::performDeleteQuery($sql);
        }
    }

} // class

?>