<!-- employeePdpActionTask_detail.tpl -->
<table border="0" width="100%" cellspacing="0" cellpadding="1">
    <tr>
        <th class="details-title">{'TASK_OWNER'|TXT_UCF}</th>
        <th class="details-title">{'COMPLETION_DATE'|TXT_UCF}</th>
        <th class="details-title">{'STATUS'|TXT_UCF}</th>
        <th class="details-title" align="right">{$actionTask.addButton}<th>
    </tr>
    <tr id="pdpactiontask_row_{$actionTask.task_id}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="details-line-value">{$actionTask.taskowner}</td>
        <td class="details-line-value">{$actionTask.end_date}</td>
        <td class="details-line-value">{$actionTask.completedLabel}</td>
        <td class="details-line-value" align="right">{$actionTask.actionButtons}</td>
    </tr>
    <tr>
        <td class="details-line-label" >{'TASK'|TXT_UCF}:</td>
        <td colspan="3" class="details-line-value">{$actionTask.task|nl2br}</td>
    </tr>
    <tr class="lastrow">
        <td class="details-line-label lastrow">{'REMARKS'|TXT_UCF}:</td>
        <td colspan="3" class="details-line-value lastrow">{$actionTask.notes|nl2br}</td>
    </tr>
</table>
<!-- /employeePdpActionTask_detail.tpl -->
