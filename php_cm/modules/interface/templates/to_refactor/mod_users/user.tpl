<!-- user.tpl -->
<div id="userDiv">
    <table width="800" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td>
                <table border="0" cellspacing="2" cellpadding="2">
                    {if $showEmployee}
                    <tr>
                        <td><strong>{'EMPLOYEE'|TXT_UCF} :</strong></td>
                        <td>{if $employeeIsInactive}<span style="text-decoration: line-through;" title="{'REMOVED'|TXT_UCF}">{/if}{$employeeName}{if $employeeIsInactive}</span>{/if}</td>
                    </tr>
                    <tr>
                        <td colspan="100%"><em>{'USER_EMPLOYEE_LINK'|TXT_UCF}</em></td>
                    </tr>
                    {else}
                    <tr>
                        <td><strong>{'DISPLAY_NAME'|TXT_UCF} : </strong></td>
                        <td>{$displayName}</td>
                    </tr>
                    {if $show_no_employee_link_text}
                    <tr>
                        <td colspan="100%"><em>{'NO_USER_EMPLOYEE_LINK'|TXT_UCF}</em></td>
                    </tr>
                    {/if}
                    {/if}
                    <tr>
                        <td><strong>{'E_MAIL_ADDRESS'|TXT_UCF} : </strong></td>
                        <td>{$emailAddress}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>{'SECURITY'|TXT_UCF} : </strong></td>
                        <td>{$userLevelName}</td>
                    </tr>
                    <tr>
                        <td><strong>{'USERNAME'|TXT_UCF} : </strong></td>
                        <td class="{if $userIsInactive}inactive{/if}">{$username}</td>
                    </tr>
                    <tr>
                        <td><strong>{'ACTIVE'|TXT_UCF} : </strong></td>
                        <td>{if $userIsInactive}{'NO'|TXT_UCF}{else}{'YES'|TXT_UCF}{/if}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>{'LAST_LOGIN'|TXT_UCF} : </strong></td>
                        <td>{$lastLogin}</td>
                    </tr>
                </table>
            </td>
            <td>
                {if !$show_departments}
                <div id="employee_div">
                    <strong>{if $show_not_applicable_employee}
                            {'DEPARTMENTS_ARE_NOT_APPLICABLE_FOR_SECURITYLEVEL_EMPLOYEES'|TXT_UCF}
                            {elseif $show_not_applicable_admin}
                            {'DEPARTMENTS_ARE_NOT_APPLICABLE_FOR_SECURITYLEVEL_ADMIN'|TXT_UCF}
                            {/if}
                    </strong>
                </div>
                {else}
                <div id="departments_div">

                    <h2>{'ACCESS'|TXT_UCF}: </h2>
                    {if $allow_access_all_departments}
                    <strong>{'SHOW_ALL_DEPARTMENTS'|TXT_UCF}</strong><br />
                    {else}
                    <div id="deptdiv">
                        <ul>
                            {foreach $allowedDepartments as $department}
                                <li>{$department['name']} </li>
                            {/foreach}
                        </ul>
                    </div>
                    {/if}
                </div>
                {/if}
            </td>
        </tr>
    </table>
</div>
<!-- end user.tpl -->