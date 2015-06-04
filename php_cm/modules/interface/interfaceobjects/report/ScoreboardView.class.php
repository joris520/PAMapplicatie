<?php

/**
 * Description of ScoreboardView
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class ScoreboardView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = NULL;

    private $employeeId;
    private $score;

    static function create($displayWidth)
    {
        return new ScoreboardView(  $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeId ($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    function getEmployeeId ()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setScore ($score)
    {
        $this->score = $score;
    }

    function getScore ()
    {
        return $this->score;
    }
}

?>
