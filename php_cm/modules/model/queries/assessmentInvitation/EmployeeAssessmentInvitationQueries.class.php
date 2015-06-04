<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeAssessmentInvitationQueries
 *
 * @author ben.dokter
 */
class EmployeeAssessmentInvitationQueries
{
    static function getHashFromInvitations($s_hash_id)
    {
        $sql = 'SELECT
                    hash_id
                FROM
                    threesixty_invitations
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }
}

?>
