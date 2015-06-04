<?php

/**
 * Description of EmployeeResultListView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/list/EmployeeResultView.class.php');

class EmployeeResultListView extends EmployeeResultView
{
    const DETAIL_TEMPLATE_FILE = 'list/resultViewDetail/listDetailView.tpl';

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultListView(  $employeeId,
                                            $employeeName,
                                            $employeeNameHtmlId,
                                            $displayWidth,
                                            self::DETAIL_TEMPLATE_FILE);
    }

}

?>
