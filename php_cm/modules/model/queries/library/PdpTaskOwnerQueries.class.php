<?php

/**
 * Description of PdpTaskOwnership
 *
 * @author ben.dokter
 */
class PdpTaskOwnerQueries
{

    static function updateForEmployee($i_employeeId, $s_employeeName)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    pdp_task_ownership
                SET
                    name = "' . mysql_real_escape_string($s_employeeName) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }
}

?>
