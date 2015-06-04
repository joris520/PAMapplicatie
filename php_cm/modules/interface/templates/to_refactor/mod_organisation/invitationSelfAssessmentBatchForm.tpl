<!-- invitationSelfAssesmentBatchForm.tpl -->
<table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <form id="invitationSelfAssessmentBatchForm" name="invitationSelfAssessmentBatchForm" method="POST" action="javascript:void(0);" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
            {$formToken}
                <p>{'COLLECTIVE_INVITATION_SELF_ASSESSMENT'|TXT_UCW}</p>

                <table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td class="bottom_line"><strong>{'SUBJECT'|TXT_UCF} : </strong></td>
                        <td>
                            <input type="text" id="message_subject" name="message_subject" size="40" value="{'SELF_EVALUATION_MESSAGE_SUBJECT'|TXT_UCF}">
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line"><strong>{'MESSAGE'|TXT_UCF} : </strong></td>
                        <td><textarea name="invitation_message" id="invitation_message" cols="60" rows="10">{$invitationMessage}</textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bottom_line">
                            <table border="0" style="width:100%; background-color:#eee;">
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
                    </tr>
                </table>
                <br>

                <p>{'SELECT'|TXT_UCW} {'EMPLOYEES'|TXT_UCW}</p>
                {include file='components/select/selectEmployees.tpl'}


                <input type="submit" id="submitButton" value="{'PERFORM'|TXT_BTN}" class="btn btn_width_80">
                <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_public_organisation__displayTab();return false;">
            </form>


        </td>
    </tr>
</table>
<!-- /invitationSelfAssesmentBatchForm.tpl -->