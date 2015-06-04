<?php

/**
 * Description of AssessmentProcessActionResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionResult  extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionResult.tpl';

    private $bossLabel;
    private $message;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionResult(   $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBossLabel($bossLabel)
    {
        $this->bossLabel = $bossLabel;
    }

    function getBossLabel()
    {
        return $this->bossLabel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setMessage($message)
    {
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->message;
    }

}

?>
