<!-- emailNotification360Message.tpl -->
    <div id="tabNav">
        {$emailMenu}
    </div>
    <br/>
    <form id="neForm" name="neForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
    {$formToken}
        <table border="0" cellspacing="0" cellpadding="5" width="670" align="center" class="border1px">
            <tr>
                <td>
                    <table width="300" border="0" cellspacing="1" cellpadding="0">
                        <tr>
                            <td>
                                <strong>{$actionNotificationTitle} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                                <br />
                                <textarea id="action_message" name="action_message" cols="70" rows="15">{$actionMessage}</textarea>
                                <br />
                                <table border="0" style="width: 100%; background-color: #eee">
                                    <tr>
                                        <td colspan="2">{$subsitutionText}</td>
                                    </tr>
                                    <tr>
                                        <td>%ACTION%</td>
                                        <td>{'ACTION'|TXT_UCF}</td>
                                    </tr>
                                    <tr>
                                        <td>%ACTION_DEADLINE_DATE%</td>
                                        <td>{'DEADLINE_DATE'|TXT_UCF}</td>
                                    </tr>
                                </table>
                            <br />
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{$taskNotificationTitle} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                                <br />
                                <textarea id="task_message" name="task_message" cols="70" rows="15">{$taskMessage}</textarea>
                                <br />
                                <table border="0" style="width: 100%; background-color: #eee">
                                    <tr>
                                        <td colspan="2">{$subsitutionText}</td>
                                    </tr>
                                    <tr>
                                        <td>%TASK%</td>
                                        <td>{'TASK'|TXT_UCF}</td>
                                    </tr>
                                    <tr>
                                        <td>%ACTION_DEADLINE_DATE%</td>
                                        <td>{'DEADLINE_DATE'|TXT_UCF}</td>
                                    </tr>
                                </table>
                            <br />
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" id="submitButton" class="btn btn_width_80" value="{'SAVE'|TXT_BTN}"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
     </form>
<!-- /emailNotification360Message.tpl -->