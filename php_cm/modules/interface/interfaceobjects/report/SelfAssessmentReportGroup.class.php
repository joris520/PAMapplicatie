<?php

/**
 * Description of SelfAssessmentReportGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class SelfAssessmentReportGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentReportGroup.tpl';

    private $bossName;

    static function create( $displayWidth,
                            $bossName)
    {
        return new SelfAssessmentReportGroup(   $displayWidth,
                                                $bossName);
    }

    protected function __construct( $displayWidth,
                                    $bossName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->bossName = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(SelfAssessmentReportView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
    }

}

?>
