<!-- employeeSelfAssessmentBatchInvite.tpl -->
<h2>{'NOTIFICATION_MESSAGE'|TXT_UCW}</h2>
<table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width: 150px;">
            <label for="message_subject">{'SUBJECT'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value" style="width: 500px;">
            <input type="text" id="message_subject" name="message_subject" size="80" value="{$interfaceObject->getSubject()}">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="invitation_message">{'MESSAGE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <textarea name="invitation_message" id="invitation_message" cols="70" rows="10">{$interfaceObject->getMessage()}</textarea>
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
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
<br/>
<h2>{'SELECT'|TXT_UCW} {'EMPLOYEES'|TXT_UCW} {$interfaceObject->getRequiredFieldIndicator()}</h2>
{$interfaceObject->getEmployeesSelectorHtml()}
<br/>
<!-- /employeeSelfAssessmentBatchInvite.tpl -->