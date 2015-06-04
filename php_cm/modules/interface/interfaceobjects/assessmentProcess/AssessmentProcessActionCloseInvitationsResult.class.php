<?php

/**
 * Description of AssessmentProcessActionCloseInvitationsResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionCloseInvitationsResult extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionCloseInvitationsResult.tpl';

    private $bossLabel;
    private $canLabel;
    private $youLabel;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionCloseInvitationsResult(   $displayWidth,
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
    function setCanLabel($canLabel)
    {
        $this->canLabel = $canLabel;
    }

    function getCanLabel()
    {
        return $this->canLabel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setYouLabel($youLabel)
    {
        $this->youLabel = $youLabel;
    }

    function getYouLabel()
    {
        return $this->youLabel;
    }

}

?>
