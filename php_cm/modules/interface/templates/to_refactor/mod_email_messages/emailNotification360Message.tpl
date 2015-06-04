<!-- emailNotificationMessage.tpl -->
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
                                <strong>{$internalNotificationTitle} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                                <br />
                                <textarea id="internal_message" name="internal_message" cols="70" rows="15">{$internalMessage}</textarea>
                                <br />
                                <table border="0" style="width: 100%; background-color: #eee">
                                    <tr>
                                        <td colspan="2">{$subsitutionText}</td>
                                    </tr>
                                    <tr>
                                        <td>%EMPLOYEE%</td>
                                        <td>{'EMPLOYEE_NAME'|TXT_UCF}</td>
                                    </tr>
                                </table>
                            <br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{$externalNotificationTitle} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                                <br />
                                <textarea id="external_message" name="external_message" cols="70" rows="15">{$externalMessage}</textarea>
                                <br />
                                <table border="0" style="width: 100%; background-color: #eee">
                                    <tr>
                                        <td colspan="2">{$subsitutionText}</td>
                                    </tr>
                                    <tr>
                                        <td>%EMPLOYEE%</td>
                                        <td>{'EMPLOYEE_NAME'|TXT_UCF}</td>
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
<!-- /emailNotificationMessage.tpl -->