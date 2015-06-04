<?php

/**
 * Description of EmployeeResultScoreStatusView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/list/EmployeeResultView.class.php');
require_once('modules/interface/interfaceobjects/assessmentInvitation/AssessmentIconView.class.php');

class EmployeeResultScoreStatusView extends EmployeeResultView
{
    const TEMPLATE_FILE = 'list/resultViewDetail/employeeResultScoreStatusView.tpl';

    private $managerIconView;

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultScoreStatusView(   $employeeId,
                                                    $employeeName,
                                                    $employeeNameHtmlId,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    function setManagerIconView(AssessmentIconView $assessmentIconView)
    {
        $this->managerIconView = $assessmentIconView;
    }

    function getManagerIconView()
    {
        return $this->managerIconView;
    }

//    // icon
//    function setIconFile($iconFile)
//    {
//        $this->iconFile = $iconFile;
//    }
//
//    function getIconFile()
//    {
//        return $this->iconFile;
//    }
//
//    // title
//    function setTitle($title)
//    {
//        $this->title = $title;
//    }
//
//    function getTitle()
//    {
//        return $this->title;
//    }


}


?>