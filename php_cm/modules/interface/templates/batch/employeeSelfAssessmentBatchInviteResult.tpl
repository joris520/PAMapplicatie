<!-- employeeSelfAssessmentBatchInviteResult.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}

<table style="width:{$interfaceObject->getDisplayWidth()};" border="0" cellspacing="0" cellpadding="2">
    <tr class="">
        <td class="bottom_line" style="width:250px;">{'NUMBER_OF_INVITATIONS_SEND'|TXT_UCF}: </td>
        <td class="bottom_line">{$valueObject->getSendCount()}</td>
    </tr>
    {if $interfaceObject->showDetails() && $valueObject->getSendCount() > 0}
    {assign var=invitedList value=$valueObject->getInvitedList()}
    <tr>
        <td>&nbsp;</td>
        <td>
            <table>
                {foreach $invitedList as $employeeInvitationResult}
                <tr>
                    {if $employeeInvitationResult->isReinvited()}
                    <td title="{'REINVITED'|TXT_UCF}">
                        *&nbsp;{$employeeInvitationResult->getEmployeeName()},
                    </td>
                    {else}
                    <td>
                       &nbsp;&nbsp;{$employeeInvitationResult->getEmployeeName()},
                    </td>
                    {/if}
                    <td style="padding-left:10px;">
                        {$employeeInvitationResult->getEmployeeEmail()}
                    </td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    <tr>
        <td>{'NUMBER_OF_INVITATIONS_NOT_SEND'|TXT_UCF}: </td>
        <td>{$valueObject->getNotSendCount()}</td>
    </tr>
    {assign var=noComptenceList value=$valueObject->getNoCompetenceList()}
    {if $noComptenceList|@count > 0}
    <tr>
        <td style="text-align:right"><em>{'FUNCTIONS_WITHOUT_COMPETENCES'|TXT_UCF}: </em>&nbsp;&nbsp;&nbsp;</td>
        <td>
            <table>
                {foreach $noComptenceList as $noComptenceResult}
                <tr>
                    <td>{$noComptenceResult->getMainFunctionName()},</td>
                    <td style="padding-left:10px;">{$noComptenceResult->getEmployeeName()}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
    {assign var=noEmailList value=$valueObject->getNoEmailList()}
    {if $noEmailList|@count > 0}
    <tr>
        <td style="text-align:right"><em>{'EMPLOYEES_WITHOUT_EMAIL'|TXT_UCF}: </em>&nbsp;&nbsp;</td>
        <td>
            <table>
                {foreach $noEmailList as $noEmailResult}
                <tr>
                    <td>{$noEmailResult->getEmployeeName()}</td>
                    <td>&nbsp;</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {/if}
</table>
<br />
<!-- /employeeSelfAssessmentBatchInviteResult.tpl -->