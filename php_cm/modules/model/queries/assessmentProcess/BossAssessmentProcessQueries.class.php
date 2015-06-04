<?php

/**
 * Description of BossAssessmentProcessQueries
 *
 * @author ben.dokter
 */

class BossAssessmentProcessQueries
{
    const ID_FIELD = 'ID_BAP';

    static function getAssessmentProcessInPeriod($i_bossId, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    boss_assessment_process main
                WHERE
                    main.ID_BAP =   (   SELECT
                                            MAX(maxid.ID_BAP)
                                        FROM
                                            boss_assessment_process maxid
                                        WHERE
                                            maxid.customer_id = ' . CUSTOMER_ID . '
                                            AND maxid.boss_fid = ' . $i_bossId . '
                                            AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                            ' . $minDateFilter . '
                                    )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertAssessmentProcess($i_bossId,
                                            $d_assessmentDate,
                                            $i_assessmentProcessStatus)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    boss_assessment_process
                    (   customer_id,
                        boss_fid,
                        assessment_date,
                        assessment_process_status,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_bossId . ',
                       "' . mysql_real_escape_string($d_assessmentDate) . '",
                        ' . $i_assessmentProcessStatus . ',
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }


}

?>
