<?php

/**
 * Description of AssessmentProcessActionConfirm
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionConfirm extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionConfirm.tpl';

    private $bossLabel;
    private $message;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionConfirm(  $displayWidth,
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
