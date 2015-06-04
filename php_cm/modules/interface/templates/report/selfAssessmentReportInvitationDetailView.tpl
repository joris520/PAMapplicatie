<!-- selfAssessmentReportInvitationDetailView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">{'EMPLOYEE'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getEmployeeName()}</td>
    </tr>
    <tr>
        <td class="form-label">{'INVITATION_ID'|TXT_UCF}</td>
        <td class="form-value">{$interfaceObject->getInvitationHashLink()}</td>
    </tr>
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DATE_INVITED'|TXT_UCF}</td>
        <td class="form-value">{DateConverter::display($valueObject->getInvitationDate())}</td>
    </tr>
    <tr>
        <td class="form-label">{'IS_COMPLETED'|TXT_UCF}</td>
        <td class="form-value">
            {AssessmentInvitationCompletedConverter::image($valueObject->getCompletedStatus())}
            {AssessmentInvitationCompletedConverter::displayReport($valueObject->getCompletedStatus())}
        </td>
    </tr>
    {if $valueObject->isCompleted()}
    <tr>
        <td class="form-label">{'DATE_COMPLETED'|TXT_UCF}</td>
        <td class="form-value">{DateTimeConverter::display($valueObject->getCompletedDateTime())}</td>
    </tr>
    <tr>
        <td class="form-label">{'COMPLETED_SCORE_COUNT'|TXT_UCF}</td>
        <td class="form-value">{NumberConverter::display($valueObject->getScoreCount())}</td>
    </tr>
    {/if}
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label"><h2 style="padding-top:0px;">{'INVITATION_EMAIL'|TXT_UCF}</h2></td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DATE_SENT'|TXT_UCF}</td>
        <td class="form-value">{DateTimeConverter::display($valueObject->getSentDateTime(), TXT_UCF('NOT_YET_SEND'))}</td>
    </tr>
    {if $valueObject->isSent()}
    <tr>
        <td class="form-label">{'MESSAGE_TO_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getInvitationMessageToEmail()}&nbsp;({$valueObject->getInvitationMessageToName()})</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE_FROM_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getInvitationMessageFromEmail()}&nbsp;({$valueObject->getInvitationMessageFromName()})</td>
    </tr>
    {/if}
    <tr>
        <td class="form-label">{'SUBJECT'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getInvitationMessageId()}-{$valueObject->getInvitationMessageType()}">{$valueObject->getInvitationMessageSubject()}</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getInvitationMessageId()}-{$valueObject->getInvitationMessageType()}">{$valueObject->getInvitationMessageTemplate()|nl2br}</td>
    </tr>

    {if $valueObject->hasReminder1()}
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label"><h2 style="padding-top:0px;">{'REMINDER_EMAIL'|TXT_UCF} 1</h2></td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DATE_SENT'|TXT_UCF}</td>
        <td class="form-value">{DateTimeConverter::display($valueObject->getReminder1DateTime(), TXT_UCF('NOT_YET_SEND'))}</td>
    </tr>
    {if $valueObject->isSentReminder1()}
    <tr>
        <td class="form-label">{'MESSAGE_TO_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getReminder1MessageToEmail()}&nbsp;({$valueObject->getReminder1MessageToName()})</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE_FROM_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getReminder1MessageFromEmail()}&nbsp;({$valueObject->getReminder1MessageFromName()})</td>
    </tr>
    {/if}
    <tr>
        <td class="form-label">{'SUBJECT'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getReminder1MessageId()}-{$valueObject->getReminder1MessageType()}">{$valueObject->getReminder1MessageSubject()}</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getReminder1MessageId()}-{$valueObject->getReminder1MessageType()}">{$valueObject->getReminder1MessageTemplate()|nl2br}</td>
    </tr>
    {/if}

    {if $valueObject->hasReminder2()}
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label"><h2 style="padding-top:0px;">{'REMINDER_EMAIL'|TXT_UCF} 2</h2></td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DATE_SENT'|TXT_UCF}</td>
        <td class="form-value">{DateTimeConverter::display($valueObject->getReminder2DateTime(), TXT_UCF('NOT_YET_SEND'))}</td>
    </tr>
    {if $valueObject->isSentReminder2()}
    <tr>
        <td class="form-label">{'MESSAGE_TO_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getReminder2MessageToName()}&nbsp;({$valueObject->getReminder2MessageToEmail()})</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE_FROM_EMAIL'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getReminder2MessageFromName()}&nbsp;({$valueObject->getReminder2MessageFromEmail()})</td>
    </tr>
    {/if}
    <tr>
        <td class="form-label">{'SUBJECT'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getReminder2MessageId()}-{$valueObject->getReminder2MessageType()}">{$valueObject->getReminder2MessageSubject()}</td>
    </tr>
    <tr>
        <td class="form-label">{'MESSAGE'|TXT_UCF}</td>
        <td class="form-value" title="{$valueObject->getReminder2MessageId()}-{$valueObject->getReminder2MessageType()}">{$valueObject->getReminder2MessageTemplate()|nl2br}</td>
    </tr>
    {/if}
</table>
<!-- /selfAssessmentReportInvitationDetailView.tpl -->