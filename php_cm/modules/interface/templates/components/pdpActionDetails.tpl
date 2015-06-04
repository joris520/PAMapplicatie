<!-- pdpActionDetails tpl-->
<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="6">

<table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
        <td class="bottom_line mod_employees_tasks_heading">{'ACTION'|TXT_UCF}</td>
        <td class="bottom_line mod_employees_tasks_heading">{'PROVIDER'|TXT_UCF}</td>
        <td class="bottom_line mod_employees_tasks_heading">{'DURATION'|TXT_UCF}</td>
        <td class="bottom_line mod_employees_tasks_heading">{'COST'|TXT_UCF}</td>
        <td class="bottom_line">&nbsp;</td>
    </tr>
    <tr>
        <td class="bottom_line shaded_title">{$action.action}</td>
        <td class="bottom_line shaded_title">{$action.provider}</td>
        <td class="bottom_line shaded_title">{$action.duration}</td>
        <td class="bottom_line shaded_title">&euro; {$action.costs|number_format:2:',':'.'}</td>
        <td class="bottom_line shaded_title" align="right">
            {if $action.canEdit}
                <a href="" title="{'EDIT'|TXT_UCF} {'ACTION'|TXT_UCW}"
                   onclick="xajax_moduleEmployees_pdpActionForm_deprecated({$action.id_pdpea}, {$id_e}, 'pdpEmployeesEdit', 'Update PDP Action');return false;">
                <img src="' . ICON_EDIT . '" class="icon-style" border="0" alt="{'EDIT'|TXT_UCW} {'ACTION'|TXT_UCW}"/></a>
                <a href="" title="{'DELETE'|TXT_UCF} {'ACTION'|TXT_UCW}"
                   onclick="xajax_moduleEmployees_deletePDPActions_deprecated({$action.id_pdpea}, {$id_e});return false;">
                <img src="{'ICON_DELETE'|constant}" class="icon-style" border="0" alt="{'DELETE'|TXT_UCW} {'ACTION'|TXT_UCW}"/></a> &nbsp;
            {/if}
        </td>
    </tr>
</table>

<table width="80%" border="0" cellspacing="0" cellpadding="0" align="right">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td>
        <strong>{'ACTION_OWNER'|TXT_UCF}:</strong> {$action.owner}&nbsp; &nbsp; &nbsp;
        <strong>{'NOTIFICATION_DATE'|TXT_UCF}:</strong> {$action.start_date}&nbsp; &nbsp; &nbsp;
        <strong>{'DEADLINE_DATE'|TXT_UCF}:</strong> {$action.end_date}
        </td>
    </tr>
    <tr>
        <td><strong>{'COMPLETED'|TXT_UCF}: </strong>{if $action.is_completed}Yes{else}No{/if}</td>
    </tr>
    <tr>
        <td><strong>{'REASONS_REMARKS'|TXT_UCF}: </strong><br/>{$action.notes|nl2br}</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
{*            <div id="pdpTaskID">
                <strong>{'TASKS'|TXT_UC}: </strong> <br/>

                <div class="mod_employees_Tasks">
                    <table border="0" width="100%" cellspacing="0" cellpadding="1">
                        {foreach $tasks as $task}
                        <tr>
                            <td class="bottom_line mod_employees_tasks_heading">{'TASK_OWNER'|TXT_UCW}</td>
                            <td class="bottom_line mod_employees_tasks_heading">{'COMPLETION_DATE'|TXT_UCW}</td>
                            <td class="bottom_line mod_employees_tasks_heading">{'STATUS'|TXT_UCW}</td>
                            <td class="bottom_line mod_employees_tasks_heading">&nbsp;<td>
                        </tr>
                        <tr>
                            <td class="bottom_line shaded_title">{$task.name}</td>
                            <td class="bottom_line shaded_title">{$task.end_date}</td>
                            <td  class="bottom_line shaded_title">{$task.is_completed}</td>
                            <td class="bottom_line shaded_title" align="right">
                                {if $task.canEdit}
                                    <a href="" title="{'EDIT'|TXT_UCW} {'TASK'|TXT_UCW}"
                                       onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated({$task.ID_PDPET}, {$action.id_pdpea}, {$id_e}, {'FORM_MODE_EDIT'|constant});return false;">
                                    <img src="' . ICON_EDIT . '" class="icon-style" border="0" alt="{'EDIT'|TXT_UCW} {'TASK'|TXT_UCW}" /></a>
                                    <a href="" title="{'DELETE'|TXT_UCW} {'TASK'|TXT_UCW}"
                                       onclick="xajax_moduleEmployees_deletePDPActionsTask_deprecated({$task.ID_PDPET}, {$action.id_pdpea}, {$id_e});return false;">
                                    <img src="{'ICON_DELETE'|constant}" class="icon-style" border="0" alt="{'DELETE'|TXT_UCW} {'TASK'|TXT_UCW}"/></a> &nbsp;
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding-bottom: 7px;">
                                <strong>{'TASKS'|TXT_UCF}:</strong><br/>
                                {$task.task}<br/>
                                <strong>{'REMARKS'|TXT_UCF}:</strong><br/>
                                {$action.notes|nl2br}
                            </td>
                        </tr>
                        {foreachelse}
                            <tr><td><div class="mod_employees_Tasks">{'NO_TASKS_RETURN'|TXT_UCF}</div></td></tr>
                        {/foreach}
                    </table>
                </div>
            </div>
*}
        </td>
    </tr>
    <tr>
        <td>
            {if $showButtons}
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td>
                        <input type="button" id="moduleEmployeesPDPbackBtn" value="&laquo; {'BACK'|TXT_BTN}" class="btn btn_width_80"
                        onclick="xajax_moduleEmployees_pdpActions_deprecated({$id_e});return false;">
                        {if $canAddTask}
                            <input type="button" id="addTaskBtn" value="{'ADD_NEW_TASK'|TXT_BTN}" class="btn btn_width_150"
                            onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated('', {$id_pdpea}, {$id_e}, {'FORM_MODE_NEW'|constant});return false;">
                        {/if}
                    </td><td>
                        <div id="logs" align="right"></div>
                    </td>
                </tr>
            </table>
            {/if}
        </td>
    </tr>
</table>

</td>
</tr>
</table>
<!-- /pdpActionDetails tpl-->