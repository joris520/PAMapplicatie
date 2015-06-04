<!-- employeePdpAction_detail.tpl -->
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="right">
    <tr>
        <td width="20%" class="details-line-label">{'ACTION'|TXT_UCF} :</td>
        <td class="details-line-value">{$actionDetail.action}</td>
    </tr>
    <tr>
        <td width="20%" class="details-line-label">{'ACTION_OWNER'|TXT_UCF} :</td>
        <td class="details-line-value">{$actionDetail.actionowner} <em>{$actionDetail.owner_mode_label}</em></td>
    </tr>
    <tr>
        <td class="details-line-label">{'NOTIFICATION_DATE'|TXT_UCF} :</td>
        <td class="details-line-value">{$actionDetail.start_date}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'RELATED_COMPETENCES'|TXT_UCF} :</td>
        <td class="details-line-value">{$connectedSkills}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'REASONS_REMARKS'|TXT_UCF} :</td>
        <td class="details-line-value">{$actionDetail.notes|nl2br}</td>
    </tr>
    <tr>
    {if count($actionTasks) > 0}
        <td class="details-line-label">{'TASKS'|TXT_UCF} :&nbsp;&nbsp;{$addTaskButton}</td>
        <td class="details-line-value">
            {foreach $actionTasks as $actionTask}
            {include file='mod_employees/employeePdpActionTask_detail.tpl'}
            {/foreach}
            <br/><br/>
        </td>
    {else}
        <td colspan="2"><br/><br/></td>
    {/if}
    </tr>
</table>
<!-- /employeePdpAction_detail.tpl -->