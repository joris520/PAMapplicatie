<?php

/**
 * Description of TargetDashboardCountValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseDashboardCountValueObject.class.php');

class TargetDashboardCountValueObject extends BaseDashboardCountValueObject
{

    private $targets;

    // de create kan zonder id, aangeroepen vanuit de collection
    static function create()
    {
        return new TargetDashboardCountValueObject(NULL);
    }

    // letop: de construct MET id
    protected function __construct($bossId)
    {
        parent::__construct($bossId);
        $this->targets = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addTargetForStatus($status, $target)
    {
        $this->targets[$status] += $target;
    }

    function getTargetForStatus($status)
    {
        return $this->targets[$status];
    }

    function getStatusKeys()
    {
        return array_keys($this->targets);
    }

}

?>
