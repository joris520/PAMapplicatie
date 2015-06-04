<table width="850" border="0" cellspacing="0" cellpadding="10" align="center">
    <tr>
        <td>
            <div id="top_nav" align="right">
                <input type="button" name="genPrintAlerts1" value="&laquo; {'BACK'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleEmails_showPDPActionsNotificationAlerts();return false;" />
                <input type="button" name="genPrintAlerts" value="{'PRINT'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleEmails_processPrintAlerts(xajax.getFormValues('msgAlertForm'));return false;" />
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <b>{'PRINT_NOTIFICATION_MESSAGE_ALERTS'|TXT_UCW}</b>
            <form name="msgAlertForm" id="msgAlertForm" onsubmit="libPrintMsgAlerts();return false;">
                <table border="0" cellpadding="1" cellspacing="1" width="600" class="border1px">
                    <tr>
                        <td width="30%" class="shaded_title bottom_line"><strong>{'OPTIONS'|TXT_UCF}</strong></td>
                        <td width="35%" class="shaded_title bottom_line" id="header1">{$header1}</td>
                        <td width="35%" class="shaded_title bottom_line" id="header2">{$header2}</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="printoption" id="o1" value="1" onclick="xajax_moduleEmails_printActionAlerts();return false;" checked />{'ACTION'|TXT_UCF}<br />
                            <input type="radio" name="printoption" id="o2" value="2" onclick="xajax_moduleEmails_printTaskAlerts();return false;" />{'TASK'|TXT_UCF}<br />
                            <input type="radio" name="printoption" id="o3" value="3" onclick="xajax_moduleEmails_printActionAndTaskAlerts();return false;" />{'BOTH'|TXT_UCF}<br /><br />
                        </td>
                        <td id="select1">{$select1}</td>
                        <td id="select2">{$select2}</td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>