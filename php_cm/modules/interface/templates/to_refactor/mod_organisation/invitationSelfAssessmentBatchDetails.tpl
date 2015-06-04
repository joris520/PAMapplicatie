<!-- invitationSelfAssessmentBatchDetails.tpl -->
<h1>{'COLLECTIVE_INVITATION_SELF_ASSESSMENT'|TXT_UCW}</h1>
<table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
    <tr class="">
        <td class="bottom_line" width="250">{'NUMBER_OF_INVITATIONS_SEND'|TXT_UCF}: </td>
        <td class="bottom_line">{$invitations_send}</td>
    </tr>
    {if $show_details && $invitations_send > 0}
    <tr>
        <td>&nbsp;</td>
        <td>
            <table>
                {foreach $employees_invited_array as $invited_name}
                <tr>
                    <td>{$invited_name}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    <tr>
        <td>{'NUMBER_OF_INVITATIONS_NOT_SEND'|TXT_UCF}: </td>
        <td>{$invitations_not_send}</td>
    </tr>
    {if $show_details && $invitations_not_send_already_invited > 0}
    <tr>
        <td style="text-align:right"><em>{'ALREADY_INVITED_EMPLOYEES'|TXT_UCF}: </em>&nbsp;&nbsp;</td>
        <td>{$invitations_not_send_already_invited}<br />
            <table>
                {foreach $employees_already_invited_array as $already_invited_name}
                <tr>
                    <td>{$already_invited_name}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    {if $employees_no_competences_array|@count > 0}
        <tr>
            <td style="text-align:right"><em>{'FUNCTIONS_WITHOUT_COMPETENCES'|TXT_UCF}: </em>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <table>
                    {foreach $employees_no_competences_array as $competences_array}
                    <tr>
                        <td style="width:15%">{$competences_array|@count}&nbsp;</td>
                        <td>{$competences_array[0]['function']}</td>
                    </tr>
                    {/foreach}
                </table>
            </td>
        </tr>
    {/if}
    {if $employees_no_email_array|@count > 0}
    <tr>
        <td style="text-align:right"><em>{'EMPLOYEES_WITHOUT_EMAIL'|TXT_UCF}: </em>&nbsp;&nbsp;</td>
        <td>{$employees_no_email_array|@count}<br />
            {foreach $employees_no_email_array as $employees_no_email}
            {$employees_no_email['name']}<br />
            {/foreach}
        </td>
    </tr>
    {/if}
</table>
<br>
<!-- /invitationSelfAssessmentBatchDetails.tpl -->