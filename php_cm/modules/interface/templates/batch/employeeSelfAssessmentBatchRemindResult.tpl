<!-- employeeSelfAssessmentBatchRemindResult.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table style="width:{$interfaceObject->getDisplayWidth()};"  border="0" cellspacing="0" cellpadding="2">
    <tr class="">
        <td class="bottom_line" style="width:250px;">{'NUMBER_OF_REMINDERS_SEND'|TXT_UCF}: </td>
        <td class="bottom_line">{$valueObject->getRemindedCount()}</td>
    </tr>
    {if $interfaceObject->showDetails() && $valueObject->getRemindedCount() > 0}
    {assign var=remindedList value=$valueObject->getRemindedList()}
    <tr>
        <td>&nbsp;</td>
        <td>
            <table>
                {foreach $remindedList as $employeeInvitationResult}
                <tr>
                    <td{if $employeeInvitationResult->isReminded2()} title="{'REMINDER_CHOICE_TWO'|TXT_UCF}"{/if}>{if $employeeInvitationResult->isReminded2()}*{else}&nbsp;{/if}&nbsp;{$employeeInvitationResult->getEmployeeName()}</td>
                    <td>&nbsp;{$employeeInvitationResult->getEmployeeEmail()}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    {assign var=noEmailList value=$valueObject->getNoEmailList()}
    {if $noEmailList|@count > 0}
    <tr>
        <td class="bottom_line">{'NUMBER_OF_REMINDERS_NOT_SEND'|TXT_UCF}: </td>
        <td class="bottom_line">{$valueObject->getNotSendCount()}</td>
    </tr>
    <tr>
        <td style="text-align:right"><em>{'EMPLOYEES_WITHOUT_EMAIL'|TXT_UCF}: </em></td>
        <td>
            <table>
                {foreach $noEmailList as $employeeInvitationResult}
                <tr>
                    <td>{$employeeInvitationResult->getEmployeeName()}</td>
                    <td>&nbsp;</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    <tr>
        <td class="bottom_line">{'NUMBER_OF_INVITATIONS_NOT_SENT'|TXT_UCF}: </td>
        <td class="bottom_line">{$valueObject->getNotRemindedCount()}</td>
    </tr>
    {if $interfaceObject->showDetails() && $valueObject->getNotRemindedCount() > 0}
    {assign var=notRemindedList value=$valueObject->getNotRemindedList()}
    <tr>
        <td>&nbsp;</td>
        <td>
            <table>
                {foreach $notRemindedList as $employeeInvitationResult}
                <tr>
                    <td>{$employeeInvitationResult->getEmployeeName()}</td>
                    <td>&nbsp;{$employeeInvitationResult->getEmployeeEmail()}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
</table>
<br />
<!-- /employeeSelfAssessmentBatchRemindResult.tpl -->