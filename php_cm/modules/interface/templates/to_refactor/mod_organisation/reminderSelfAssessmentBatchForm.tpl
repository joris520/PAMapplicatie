<!-- reminderSelfAssesmentBatchForm.tpl -->
<table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <h1>{'COLLECTIVE_REMINDER_SELF_ASSESSMENT'|TXT_UCW}</h1>
            <table border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td>{'NUMBER_OF_INVITATIONS_SEND_AFTER'|TXT_UCF} {$after_date}: </td>
                    <td>{$invitations_send}</td>
                </tr>
                {if $invitations_send > 0}
                    <tr>
                        <td>{'NUMBER_OF_ASSESSMENTS_NOT_DONE'|TXT_UCF}: </td>
                        <td>{$assessments_not_completed}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    {if $reminder1_count > 0}
                    <tr>
                        <td>{'REMINDER_CHOICE_ONE'|TXT_UCF}: </td>
                        {if $reminder1_count > $reminder1_sent}
                        <td>{'PREPARED'|TXT_LC}: {$reminder1_count}, {'SENT'|TXT_LC}: {$reminder1_sent} </td>
                        {else}
                        <td>{'SENT'|TXT_LC}: {$reminder1_sent} </td>
                        {/if}
                    </tr>
                    {/if}
                    {if $reminder2_count > 0}
                    <tr>
                        <td>{'REMINDER_CHOICE_TWO'|TXT_UCF}: </td>
                        {if $reminder2_count > $reminder2_sent}
                        <td>{'PREPARED'|TXT_LC}: {$reminder2_count}, {'SENT'|TXT_LC}: {$reminder2_sent} </td>
                        {else}
                        <td>{'SENT'|TXT_LC}: {$reminder2_sent} </td>
                        {/if}
                    </tr>
                    {/if}
                {/if}
                <tr>
                    <td colspan="100%"></td>
                </tr>
            </table>
            {if $invitations_send > 0}
                {if $assessments_not_completed > 0}
                <form id="reminderSelfAssessmentBatchForm" name="reminderSelfAssessmentBatchForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
                {$formToken}
                    <table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
                        <tr>
                            <td colspan="100%"></td>
                        </tr>
                        <tr>
                            <td class="bottom_line"><strong>{'SUBJECT'|TXT_UCF} : </strong></td>
                            <td>
                                <input type="text" id="message_subject" name="message_subject" size="40" value="{$message_subject}">
                            </td>
                        </tr>
                        <tr>
                            <td class="bottom_line"><strong>{'MESSAGE'|TXT_UCF} : </strong></td>
                            <td><textarea name="reminder_message" id="reminder_message" cols="60" rows="10">{$reminder_message}</textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bottom_line">
                                <table border="0" style="width: 100%; background-color: #eee">
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
                        </tr>
                    </table>
                    <br>


                    <input type="submit" id="submitButton" value="{'PERFORM'|TXT_BTN}" class="btn btn_width_80">
                    <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_public_organisation__displayTab();return false;">

                </form>
                {if $allow_reset_button}
                <br/><br/><hr/>demo/test knoppen<br/>
                <br/><input class="btn btn_width_180" id="btn_reset" type="button" onclick="resetReminderInvitations(this.id);return false;" value="reset herinneringsuitnodigingen en tevredenheidsbrieven">
                {/if}

                {else}
                {'ALL_ASSESSMENTS_ARE_COMPLETED'|TXT_UCF}.
                {/if}
            {/if}

        </td>
    </tr>
</table>
<!-- /reminderSelfAssesmentBatchForm.tpl -->