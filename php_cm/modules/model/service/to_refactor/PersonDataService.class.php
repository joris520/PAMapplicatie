<?php

require_once('application/model/service/PersonDataService.class.php');

// TODO: refactor. Deze functie hoort hier niet!

function modulePersonData_selectEmailCluster($cluster_name, $employee_id, $already_selected) {
    global $smarty;

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        //$objResponse->alert($cluster_name);      // voor debugging
        //$objResponse->alert($already_selected);  // voor debugging
        $sql_internal = 'SELECT
                            pd.*
                        FROM
                            person_data pd
                            INNER JOIN employees e
                            ON pd.ID_PD = e.ID_PD
                                AND e.is_inactive = 0
                                AND e.ID_E <> ' . $employee_id . '
                        WHERE
                            pd.ID_EC = 1
                            AND pd.customer_id = ' . CUSTOMER_ID . '
                            AND pd.email <> ""';


        $sql_external = 'SELECT
                            pd.*
                        FROM
                            person_data pd
                        WHERE
                            pd.ID_EC = 2
                            AND pd.customer_id = ' . CUSTOMER_ID . '
                            AND pd.email <> ""';

        if (!empty($already_selected)) {
            $sql_exclude = ' AND pd.ID_PD NOT IN (' . $already_selected . ')';
        } else {
            $sql_exclude = ' ';
        }


        switch($cluster_name) {
            case "internal":
                $sql = $sql_internal .
                       $sql_exclude;
                break;

            case "external":
                $sql = $sql_external .
                       $sql_exclude;
                break;

            default:
                $sql = $sql_internal .
                       $sql_exclude .

                       ' UNION ' .

                        $sql_external .
                        $sql_exclude;
        }
        $sql .= ' ORDER BY
                    lastname,
                    firstname';

        $clusterQuery = BaseQueries::performQuery($sql);

        $entries = MysqlUtils::result2Array2D($clusterQuery);

        $tpl = $smarty->createTemplate('components/select/selectEmails_selectCluster.tpl');
        $tpl->assign('entries', $entries);

        $objResponse->assign('selectCluster', 'innerHTML', $smarty->fetch($tpl));
    }

    return $objResponse;
}


?>
