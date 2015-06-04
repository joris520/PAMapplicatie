<!-- reminderSelfAssessmentBatchDetails.tpl -->
<h1>{'COLLECTIVE_REMINDER_SELF_ASSESSMENT'|TXT_UCW}</h1>
<table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
    <tr class="">
        <td class="bottom_line" width="250">{'REMINDER_FOR_SELF_EVALUATION'|TXT_UCF} {'PREPARED'|TXT_LC}:</td>
        <td class="bottom_line">{$reminders_send}</td>
    </tr>
    {if $show_details}
    {if $reminded_employees1|@count > 0}
    <tr>
        <td>{'REMINDER_CHOICE_ONE'|TXT_UCF}:</td>
        <td><table>
                {foreach $reminded_employees1 as $reminded_employee_name}
                <tr>
                    <td>{$reminded_employee_name}</td>
                </tr>
                {/foreach}
            </table>
    </tr>
    {/if}
    <br>
    {if $reminded_employees2|@count > 0}
    <tr>
        <td>{'REMINDER_CHOICE_TWO'|TXT_UCF}:</td>
        <td><table>
                {foreach $reminded_employees2 as $reminded_employee_name}
                <tr>
                    <td>{$reminded_employee_name}</td>
                </tr>
                {/foreach}
            </table>
    </tr>
    {/if}
    {/if}

</table>
<br>
<!-- /reminderSelfAssessmentBatchDetails.tpl -->