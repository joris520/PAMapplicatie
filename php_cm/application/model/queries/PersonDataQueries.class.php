<?php

/**
 * Description of PersonDataQueries
 *
 * @author ben.dokter
 */

class PersonDataQueries
{

    static function getPersonData($i_person_data_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    person_data
                WHERE
                    ID_PD = ' . $i_person_data_id . '
                    AND customer_id = ' . CUSTOMER_ID;

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertPersonData($i_customer_id, $i_email_cluster_id, $s_firstname, $s_lastname, $s_email_address)
    {
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    person_data
                    (   customer_id,
                        id_ec,
                        firstname,
                        lastname,
                        email,
                        modified_by_user,
                        modified_datetime
                    ) VALUES (
                         ' . $i_customer_id . ',
                         ' . $i_email_cluster_id . ' ,
                        "' . mysql_real_escape_string($s_firstname) . '",
                        "' . mysql_real_escape_string($s_lastname) . '",
                        "' . mysql_real_escape_string($s_email_address) . '",
                        "' . $modified_by_user . '",
                        "' . $modified_datetime . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }


    static function updatePersonalData($i_persondata_id, $i_customer_id, $i_email_cluster_id, $s_firstname, $s_lastname, $s_email_address)
    {
        $modified_by_user = USER;
        $modified_date_time = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    person_data
                SET
                    customer_id = ' . $i_customer_id . ',
                    id_ec = ' . $i_email_cluster_id . ',
                    firstname = "' . mysql_real_escape_string($s_firstname) . '",
                    lastname =  "' . mysql_real_escape_string($s_lastname) . '",
                    email =     "' . mysql_real_escape_string($s_email_address) . '",
                    modified_by_user = ' . $modified_by_user . ',
                    modified_datetime = ' . $modified_date_time . '
                WHERE
                    ID_PD = ' . $i_persondata_id;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateForEmployee($i_employeeId, $s_firstname, $s_lastname, $s_emailAddress)
    {
        $modified_by_user = USER;
        $modified_date_time = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    person_data pd
                    INNER JOIN employees e
                        ON e.ID_PD = pd.ID_PD
                SET
                    pd.firstname = "' . mysql_real_escape_string($s_firstname) . '",
                    pd.lastname = "' . mysql_real_escape_string($s_lastname) . '",
                    pd.email = "' . mysql_real_escape_string($s_emailAddress) . '",
                    pd.modified_by_user = "' . $modified_by_user . '",
                    pd.modified_datetime = "' . $modified_date_time . '"
                WHERE
                    pd.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E =' .  $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateEmailForEmployee($i_employeeId, $s_emailAddress)
    {
        $modified_by_user = USER;
        $modified_date_time = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    person_data pd
                    INNER JOIN employees e
                        ON e.ID_PD = pd.ID_PD
                SET
                    pd.email = "' . mysql_real_escape_string($s_emailAddress) . '",
                    pd.modified_by_user = "' . $modified_by_user . '",
                    pd.modified_datetime = "' . $modified_date_time . '"
                WHERE
                    pd.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E =' .  $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }


    static function getPersonDataByEmployeeId($i_employee_id)
    {
        $sql = 'SELECT
                    pd.*
                FROM
                    person_data pd
                    INNER JOIN employees e
                        ON e.ID_PD = pd.ID_PD
                WHERE
                    pd.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E =' .  $i_employee_id;

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
