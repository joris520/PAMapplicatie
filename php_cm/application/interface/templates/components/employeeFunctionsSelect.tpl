<!-- employeeFunctionsSelect.tpl -->
<input type=hidden name="selectedID_Fs" id="selectedID_Fs" value="{$employeeFunctionsIds}">
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="200">{'JOB_PROFILES_OF_EMPLOYEE'|TXT_UCF} :<br>
            &nbsp;&nbsp;&nbsp;<em>{'AVAILABLE_JOB_PROFILES'|TXT_UCF}</em>
        </td>
        <td width="50">&nbsp;</td>
        <td>&nbsp;<br>&nbsp;<em>{'SELECTED'|TXT_UCF}</em></td>
    </tr>
    <tr>
        <td align="right">{$sourceFunctions}</td>
        <td align="center" valign="middle">
            &nbsp;<br>
            <input type="reset" name="forward" id="buttonadd" value="&gt;&gt;" onclick="moveJobProfile(); return false;"/> <br>
            <br>
            <input type="reset" name="back" id="buttonremove" value="&lt;&lt;" onclick="moveJobProfile('remove'); return false;"/>
        </td>
        <td align="left">{$destinationFunctions}</td>
    </tr>
</table>
<!-- /employeeFunctionsSelect.tpl -->