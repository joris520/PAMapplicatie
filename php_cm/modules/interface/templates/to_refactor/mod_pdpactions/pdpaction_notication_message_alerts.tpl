<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td>
            <br />
            <br />
            <div id="naID">
                <table width="850" border="0" cellspacing="0" cellpadding="10" align="center">
                    <tr>
                        <td>
                            <div id="top_nav" align="right">
                                <input type="button" name="genPrintAlerts" value="{'GENERATE_MESSAGE_ALERTS_PRINT'|TXT_BTN}" class="btn btn_width_180" onclick="xajax_moduleEmails_printAlerts();return false;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>{'PDP_ACTION_NOTIFICATION_MESSAGE'|TXT_UC}</b><br />
                            {if empty($pdpactionalerts)}
                                <table border="0" cellspacing="1" cellpadding="3" class="border1px" width="100%">
                                    <tr>
                                        <td>{'NO_NOTIFICATION_ALERT_RETURN_ON_PDP_ACTION'|TXT_UCF}</td>
                                    </tr>
                                </table>
                            {else}
                                <table border="0" cellspacing="1" cellpadding="1" class="border1px" width="100%">
                                    <tr>
                                        <td class="shaded_title bottom_line" width="20%"><b>{'ACTION'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'EMPLOYEE'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'ACTION_OWNER'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="25%"><b>{'NOTIFICATION_EMAILS'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'NOTIFICATION_DATE'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="10%"><b>{'SENT'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="10%"><b>{'CONFIRMED'|TXT_UCW}</b></td>
                                    </tr>

                                    {foreach $pdpactionalerts as $pdpactionalert}
                                        <tr>
                                            <td class="bottom_line">{$pdpactionalert.action}</td>
                                            <td class="bottom_line">{$pdpactionalert.employee}</td>
                                            <td class="bottom_line">{$pdpactionalert.name}</td>
                                            <td class="bottom_line">{if $pdpactionalert.is_done == 1} {$pdpactionalert.sent_email} {else} {$pdpactionalert.email}{/if}</td>
                                            <td class="bottom_line">{$pdpactionalert.alert_date}</td>
                                            <td class="bottom_line">{$pdpactionalert.is_done_label|TXT_UCF}</td>
                                            <td class="bottom_line">{$pdpactionalert.is_confirmed_label|TXT_UCF}</td>
                                        </tr>
                                    {/foreach}
                                </table>
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>{'PDP_TASKS_MESSAGE_ALERTS'|TXT_UC}</b><br />
                            {if empty($pdpactiontasksalerts)}
                                <table border="0" cellspacing="1" cellpadding="3" class="border1px" width="100%">
                                    <tr>
                                        <td>{'NO_NOTIFICATION_ALERT_RETURN_ON_PDP_ACTION'|TXT_UCF}</td>
                                    </tr>
                                </table>
                            {else}
                                <table border="0" cellspacing="1" cellpadding="1" class="border1px" width="100%">
                                    <tr>
                                        <td class="shaded_title bottom_line" width="20%"><b>{'TASK'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'EMPLOYEE'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'TASK_OWNER'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="25%"><b>{'NOTIFICATION_EMAILS'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="15%"><b>{'NOTIFICATION_DATE'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="10%"><b>{'SENT'|TXT_UCW}</b></td>
                                        <td class="shaded_title bottom_line" width="10%"><b>{'CONFIRMED'|TXT_UCW}</b></td>
                                    </tr>
                                    {foreach $pdpactiontasksalerts as $pdpactiontaskalert}
                                        <tr>
                                            <td class="bottom_line">{$pdpactiontaskalert.task}</td>
                                            <td class="bottom_line">{$pdpactiontaskalert.employee}</td>
                                            <td class="bottom_line">{$pdpactiontaskalert.name}</td>
                                            <td class="bottom_line">{if $pdpactiontaskalert.is_done == 1}{$pdpactiontaskalert.sent_email}{else}{$pdpactiontaskalert.email}{/if}</td>
                                            <td class="bottom_line">{$pdpactiontaskalert.alert_date}</td>
                                            <td class="bottom_line">{$pdpactiontaskalert.is_done_label|TXT_UCF}</td>
                                            <td class="bottom_line">{$pdpactiontaskalert.is_confirmed_label|TXT_UCF}</td>
                                        </tr>
                                    {/foreach}
                                </table>
                            {/if}
                        </td>
                    </tr>
                </table>
            </div>
            <br />
        </td>
    </tr>
</table>

