<!-- employeeJobProfileEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<input type=hidden name="selectedID_Fs" id="selectedID_Fs" value="{implode(',',$interfaceObject->getFunctionIds())}">
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" colspan="2">
            <label for="sourceSelect">{'JOB_PROFILES_OF_EMPLOYEE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td >&nbsp;</td>
        <td style="width:300px;">
            <em>{'AVAILABLE_JOB_PROFILES'|TXT_UCF}</em>
        </td>
        <td width="80">&nbsp;</td>
        <td style="width:300px;">
            <em>{'SELECTED'|TXT_UCF}</em>
        </td>
    </tr>
    <tr>
        <td class="">&nbsp;</td>
        <td class="form-value" align="left">
            {* hier moeten alle functieprofielen minus de hoofd- en nevenfunctieprofielen in lijstje getoond worden *}
            <select name="sourceSelect" id="sourceSelect" size="10" style="width:100%" multiple="multiple" ondblclick="moveJobProfile(); return false;">
                {include    file='components/selectIdValuesComponent.tpl'
                            idValues=$interfaceObject->getUnusedFunctionIdValues()
                            currentValue=NULL
                            required=true}
            </select>
        </td>
        <td align="center" valign="middle">
            &nbsp;<br />
            <input type="reset" name="forward" id="buttonadd" value="&gt;&gt;" onclick="moveJobProfile(); return false;"/> <br />
            <br>
            <input type="reset" name="back" id="buttonremove" value="&lt;&lt;" onclick="moveJobProfile('remove'); return false;"/>
        </td>
        <td align="left">
            {* hier moeten alle functieprofielen minus de hoofd- en nevenfunctieprofielen in lijstje getoond worden *}
            <select name="destinationSelect" id="destinationSelect" size="10" style="width:100%;" multiple="multiple" ondblclick="moveJobProfile(); return false;">
                {include    file='components/selectIdValuesComponent.tpl'
                            idValues=$interfaceObject->getFunctionIdValues()
                            currentValue=NULL
                            required=true}
            </select>
        </td>
    </tr>
</table>
<br />
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td class="form-label" style="width:200px;">
            <label for="ID_FID">{'MAIN_JOB_PROFILE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <select name="ID_FID" id="ID_FID">
            {include    file='components/selectIdValuesComponent.tpl'
                        idValues=$interfaceObject->getFunctionIdValues()
                        currentValue=$valueObject->getMainFunctionId()
                        required=false
                        subject='MAIN_JOB_PROFILE'|TXT_LC}
            </select>
        </td>
    </tr>
    <tr>
        <td class="form-label"><label for="note_note">{'REMARKS'|TXT_UCF}</label></td>
        <td class="form-value">
            <textarea id="note" name="note" style="height:50px;" cols="60">{$valueObject->getNote()}</textarea>
        </td>
    </tr>
</table>
<!-- /employeeJobProfileEdit.tpl -->