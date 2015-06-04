<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of History
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/to_refactor/HistoryQueries.class.php');
require_once('gino/DateUtils.class.php');

class HistoryService {

    static function getLastTimeshotdateHtml($employee_id)
    {
        $date_display = '';

        $historyPointQuery = HistoryQueries::lastHistorypoint($employee_id);
        $historyPoint = mysql_fetch_assoc($historyPointQuery);

        if (!empty($historyPoint)) {
            $date_display = DateUtils::convertToDisplayDate($historyPoint['eh_date']);
        } else {
            $date_display = '<span style="color:red">' . TXT_UCF('NO_HISTORY_SAVED'). '.</span>';
        }
        return $date_display;
    }

}

?>
