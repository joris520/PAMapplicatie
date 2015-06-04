<!-- employeeSelfAssessmentBatchRemind.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr id="invited_count_row" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td  style="width:150px;">{'NUMBER_OF_INVITATIONS'|TXT_UCF}: </td>
        <td>
            {$interfaceObject->getInvitedCount()}{if $interfaceObject->getInvitedCount() != $interfaceObject->getSentCount()}&nbsp;&nbsp;({'SENT'|TXT_LC}: {$interfaceObject->getSentCount()}){/if}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getInvitedDetailLink()}
        </td>
    </tr>
    <tr id="not_completed_count_row" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td>{'NUMBER_OF_ASSESSMENTS_NOT_DONE'|TXT_UCF}: </td>
        <td>
            {$interfaceObject->getNotCompletedCount()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getNotCompletedDetailLink()}
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
<h2>{'REMINDER_EMAIL'|TXT_UCF}</h2>
<table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    {if $interfaceObject->needsReminder()}
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="message_subject">{'SUBJECT'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value" style="width:500px;">
            <input type="text" id="message_subject" name="message_subject" size="80" value="{$interfaceObject->getSubject()}">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="reminder_message">{'MESSAGE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <textarea name="reminder_message" id="invitation_message" cols="70" rows="10">{$interfaceObject->getMessage()}</textarea>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <table border="0" style="width:100%; background-color:#ccc;">
                <tr>
                    <td colspan="2">
                        {'THESE_TOKENS_WILL_BE_SUBSTITUTED_WITH_RELEVANT_DATA_WHEN_SENT'|TXT_UCF}.
                    </td>
                </tr>
                <tr>
                    <td><strong>%EMPLOYEE%</strong></td>
                    <td>{'EMPLOYEE_NAME'|TXT_UCF}</td>
                </tr>
                <tr>
                    <td><strong>%INVITATION_DATE%</strong></td>
                    <td>{'INVITATION_DATE'|TXT_UCF}</td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
    {else}
    {'NO_REMINDERS_ARE_NEEDED'|TXT_UCF}.
    {/if}
</table>
<br/>
<!-- /employeeSelfAssessmentBatchRemind.tpl -->