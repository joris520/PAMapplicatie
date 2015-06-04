<!-- satisfactionLetterSelfAssessmentBatchDetails.tpl -->
<h1>{'COLLECTIVE_SELF_ASSESSMENT_LETTER_OF_SATISFACTION'|TXT_UCW}</h1>
<table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
    <tr class="">
        <td class="bottom_line" width="250">{'NUMBER_OF_LETTERS_SEND'|TXT_UCF}: </td>
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
    </tr>
    {/if}
    <tr>
        <td>{'NUMBER_OF_LETTERS_NOT_SEND'|TXT_UCF}: </td>
        <td>{$invitations_not_send}</td>
    </tr>
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
<!-- /satisfactionLetterSelfAssessmentBatchDetails.tpl -->