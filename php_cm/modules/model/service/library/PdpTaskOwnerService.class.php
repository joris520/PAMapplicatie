<?php
/**
 * Description of PdpTaskOwnerService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/library/PdpTaskOwnerQueries.class.php');

class PdpTaskOwnerService
{

    static function updateForEmployee($employeeId, $employeeName)
    {
        return PdpTaskOwnerQueries::updateForEmployee($employeeId, $employeeName);
    }
}

?>
