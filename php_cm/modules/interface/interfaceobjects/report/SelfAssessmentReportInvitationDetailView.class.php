<?php

/**
 * Description of SelfAssessmentReportInvitationDetailView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class SelfAssessmentReportInvitationDetailView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentReportInvitationDetailView.tpl';

    private $invitationHashLink;

    static function createWithValueObject(  SelfAssessmentReportInvitationDetailValueObject $valueObject,
                                            $displayWidth)
    {
        return new SelfAssessmentReportInvitationDetailView($valueObject,
                                                            $displayWidth,
                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitationHashLink($invitationHashLink)
    {
        $this->invitationHashLink = $invitationHashLink;
    }

    function getInvitationHashLink()
    {
        return $this->invitationHashLink;
    }
}

?>
