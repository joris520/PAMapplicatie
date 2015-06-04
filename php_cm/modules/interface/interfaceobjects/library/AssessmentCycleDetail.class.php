<?php

/**
 * Description of AssessmentCycleDetail
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentCycleDetail extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleDetail.tpl';

    private $interfaceObject;

    static function createWithInterfaceObject(  AssessmentCycleInfoDetail $interfaceObject,
                                                $displayWidth)
    {
        return new AssessmentCycleDetail(   $interfaceObject,
                                            $displayWidth);
    }

    function __construct(   AssessmentCycleInfoDetail $interfaceObject,
                            $displayWidth = '')
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->interfaceObject  = $interfaceObject;
    }

    function getInterfaceObject()
    {
        return $this->interfaceObject;
    }
}

?>
