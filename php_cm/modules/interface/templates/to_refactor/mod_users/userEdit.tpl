<!-- userEdit.tpl -->
<div id="userDiv">
    <strong>{$actionLabel}</strong><br />
    <hr />
    <form id="userForm" name="userForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
	{$form_token}
    {if $showEmployee}
	<input type="hidden" name="displayName" value="{$employeeName}" />
    {/if}
    <table width="800" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td>
                <table border="0" cellspacing="2" cellpadding="2">
                    {if $showEmployee}
                    <tr>
                        <td><strong>{'EMPLOYEE'|TXT_UCF}:</strong></td>
                        <td>{if $employeeIsInactive}<span style="text-decoration: line-through;" title="{'REMOVED'|TXT_UCF}">{/if}{$employeeName}{if $employeeIsInactive}</span>{/if}</td>
                    </tr>
                    {else}
                    <tr>
                        <td><strong>{'DISPLAY_NAME'|TXT_UCF}: </strong></td>
                        <td>
                            <input name="displayName" type="text" id="displayName" size="25" value="{$displayName}" />
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td><strong>{'E_MAIL_ADDRESS'|TXT_UCF} :</strong> </td>
                        <td><input name="email" type="text" id="email" size="25" value="{$emailAddress}" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>{'SECURITY'|TXT_UCF} :</strong> </td>
                        <td>
                            {if $showSecuritySelect}
                            <select name="user_level" id="user_level" {$user_level_readonly} onChange="javascript:changedUserLevel('user_level', 'departments_div', 'no_department_div', 2, 3); return false;">
                                <option value="">- {'SELECT_SECURITY_LEVEL'|TXT_LC} -</option>
                                {foreach $securityLevels as $securityLevel}
                                    <option value="{$securityLevel['level_id']}"{if $userLevel == $securityLevel['level_id']} selected{/if}>{$securityLevel['level_name']}</option>
                                {/foreach}
                            </select>
                            {else}
                            {foreach $securityLevels as $securityLevel}
                            {$securityLevel['level_name']}
                            {/foreach}
                            {/if}
                        </td>
                    </tr>

                    {if !empty($userId)}
                    <tr>
                        <td><strong>{'USERNAME'|TXT_UCF} :</strong> </td>
                        <td>{$userName}</td>
                    </tr>
                    <tr>
                        <td><strong>{'ACTIVE'|TXT_UCF} : </strong></td>
                        <td>
                            <select name="user_enabled" id="user_enabled" {if $employeeIsInactive}disabled="disabled"{/if}>
                                <option value="1" >{'YES'|TXT_LC}</option>
                                <option value="0" {if $userIsInactive}selected="selected"{/if}>{'NO'|TXT_LC}</option>
                            </select>
                        </td>
                    </tr>

                    {/if}
                </table>
                {if !empty($userId)}
                <div id="open_change_username">
                    <br /><a href="#"
                             onClick="javascript:showSettingsInDiv('edit_username', 'open_change_username'); return false;">{'CLICK_HERE_TO_CHANGE_USERNAME_OR_PASSWORD'|TXT_UCF}</a>
                </div>
                {/if}
                <div id="edit_username" {if !empty($userId)}style="display:none;"{/if}>
                    <table border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        {if !empty($userId)}
                        <tr>
                            <td colspan="2"><span class="smalltext"><em>({'LEAVE_BLANK_IF_NOT_NECESSARY_TO_CHANGE_THE_USERNAME_AND_PASSWORD'|TXT_UCF})</em></span></td>
                        </tr>
                        {/if}
                        <tr>
                            <td><strong>{'USERNAME'|TXT_UCF} :</strong> </td>
                            <td><input name="username" type="text" id="username" value="{$userName}" size="25" /></td>
                        </tr>
                        <tr>
                            <td><strong>{'PASSWORD'|TXT_UCF} : </strong></td>
                            <td><input name="password" type="password" id="password" size="25" /></td>
                        </tr>
                        <tr>
                            <td><strong>{'CONFIRM'|TXT_UCF} : </strong></td>
                            <td><input name="confirm" type="password" id="confirm" size="25" /></td>
                        </tr>

                    </table>
                </div>
            </td>
            <td>
                <div id="no_department_div1" style="display:none">
                    <strong>{'DEPARTMENTS_ARE_NOT_APPLICABLE_FOR_SECURITYLEVEL_ADMIN'|TXT_UCF}</strong>
                </div>
                <div id="no_department_div4" style="display:none">
                    <strong>{'DEPARTMENTS_ARE_NOT_APPLICABLE_FOR_SECURITYLEVEL_EMPLOYEES'|TXT_UCF}</strong>
                </div>
                <div id="no_department_div5" style="display:none">
                    <strong>{'DEPARTMENTS_ARE_NOT_APPLICABLE_FOR_SECURITYLEVEL_EMPLOYEES'|TXT_UCF}</strong>
                </div>
                <div id="departments_div" style="display:none">
                <h2>{'ACCESS'|TXT_UCF}: </h2>

                {assign var="checked_allow_access_all_departments" value=""}
                {if $allow_access_all_departments}
                    {assign var="checked_allow_access_all_departments" value="checked"}
                {/if}

                <strong>{'SHOW_ALL_DEPARTMENTS'|TXT_UCF} : <input type="checkbox" name="allow_access_all_departments"
                            {$checked_allow_access_all_departments} onclick="$('#deptdiv').find(':checkbox').attr('disabled', this.checked)" /></strong>
                    <div id="deptdiv">
                        <table class="border1px" width="300">
                            <tr>
                                <td class="bottom_line">
                                    <strong>{'DEPARTMENT'|TXT_UCF}</strong>
                                </td>
                                <td class="bottom_line">
                                    <strong>{'PERMISSION'|TXT_UCF}</strong>
                                </td>
                            </tr>
                            {foreach $departmentPermissions as $deptperm}
                            <tr>
                                <td>{$deptperm['name']} : &nbsp; </td>
                                <td>
                                    <input type="checkbox" id="dept{$deptperm['deptId']}" name="dept{$deptperm['deptId']}" value="{$deptperm['deptId']}" {if $deptperm['permission']}checked{/if} {if $allow_access_all_departments}disabled{/if} />
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </div>
                <div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 <input type="submit" id="submitButton" value="{'SAVE'|TXT_BTN}" class="btn btn_width_80" />&nbsp;
                 <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleUsers();return false;" />
            </td>
        </tr>
    </table>
    </form>
</div>
<!-- end userEdit.tpl -->