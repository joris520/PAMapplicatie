{* smarty *}

<!-- selectEmployees.tpl -->
{* <input type="hidden" value="3" name="op">  ?? *}
{if $additional_functions}{assign var='additionalFunctions' value='1'}{else}{assign var='additionalFunctions' value='0'}{/if}
<div class="mod_employees_empPrint">
        <table width="99%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                        <td width="30%"><strong>{'OPTIONS'|TXT_UCF}</strong></td>
                        <td><strong>{'DEPARTMENT'|TXT_UCF}</strong></td>
                        {if !$hide_functionprofile_option}
                        <td><strong>{'JOB_PROFILES'|TXT_UCF}</strong></td>
                        {/if}
                        {if $show_employees_bosses || $show_employees_bosses_new}
                        <td><strong>{'BOSSES'|TXT_UCF}</strong>
                            <br/>
                            {if $show_employees_bosses}
                            <span style="font-size:smaller;">{'CTRL_CLICK_FOR_MULTI_SELECT'|TXT_UCF}</span>
                            {/if}
                        </td>
                        {/if}

                        <td><strong>{'EMPLOYEE'|TXT_UCF} / {'CROSS_SELECTION'|TXT_UCF}</strong>
{* *}
                            <br />
                            <span style="font-size:smaller;">{'CTRL_CLICK_FOR_MULTI_SELECT'|TXT_UCF}</span>
{* *}
                        </td>
                </tr>
                <tr>
                    <td class="border1px">
                        <input type="radio" name="option" value="1" {if !$employee_edit_or_view}onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"{/if} checked="checked"/> {'SINGLE_EMPLOYEE'|TXT_UCF}
                        {if !$employee_edit_or_view}
                                / {'CROSS_SELECTION'|TXT_UCF} <br />
                            {if !$hide_department_option}
                                <input type="radio" name="option" value="2" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'EMPLOYEES_WITH_DEPARTMENT'|TXT_UCF} <br />
                            {/if}
                            {if $show_department_option_new}
                                <input type="radio" name="option" value="9" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'EMPLOYEES_WITH_DEPARTMENT'|TXT_UCF} <br />
                            {/if}
                            {if !$hide_functionprofile_option}
                                <input type="radio" name="option" value="3" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'JOB_PROFILE_GROUP'|TXT_UCF} <br />
                                <input type="radio" name="option" value="4" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'JOB_PROFILE_GROUP_IN_DEPARTMENT'|TXT_UCF} <br />
                            {/if}
                            {if $show_employees_bosses}
                                <input type="radio" name="option" value="7" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'EMPLOYEES_BOSSES'|TXT_UCF} <br />
                            {/if}
                            {if $show_employees_bosses_new}
                                <input type="radio" name="option" value="8" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'EMPLOYEES_BOSSES'|TXT_UCF} <br />
                            {/if}
                            {if $employees_against_job_profile}
                                <input type="radio" name="option" value="6" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'EMPLOYEES_AGAINST_JOB_PROFILE'|TXT_UCF} <br />
                            {/if}
                            {if !$hide_all_employees_option}
                                <input type="radio" name="option" value="5" onclick="selectEmployees_control(this.value, 0, {$additionalFunctions}, xajax.getFormValues(this.form.id));"/> {'ALL_EMPLOYEES'|TXT_UCF} <br />
                            {/if}
                            {if $show_email_filled_in_filter}
                                <input type="checkbox" name="SBemail" value="1" onclick="empSearchEmployee(this);" checked /> {'SHOW_ONLY_EMPLOYEES_WITH_FILLED_IN_EMAIL_ADDRESSES'|TXT_UCF} <br />
                            {/if}
                            {if $show_assessment_filled_in_filter}
                                <input type="checkbox" name="SBself_assessment_not_invited" value="1" onclick="empSearchEmployee(this);" checked />{'SHOW_ONLY_EMPLOYEES_WITHOUT_ASSESSMENT_INVITATIONS'|TXT_UCF} <br />
                            {/if}
                            {if $show_assessment_completed_filter}
                                <input type="checkbox" name="SBself_assessment_both_completed" value="1" onclick="empSearchEmployee(this);" checked />{'SHOW_ONLY_EMPLOYEES_WITH_COMPLETED_ASSESSMENTS'|TXT_UCF} <br />
                            {/if}
                            {if $use_selfassessment_active}
                                <input type="hidden" name="selfassessment_active" value="1">
                            {/if}
                        {/if}

                        </td>
                        {if !$hide_department_option}
                        <td class="border1px">
                                <select name="SBdepartment" id="SBdepartment" size="20" disabled="disabled" class="disabled" onchange="">
                                {foreach $depts as $dept}
                                        <option value="{$dept.ID_DEPT}">{$dept.department}</option>
                                {/foreach}
                                </select>
                        </td>
                        {/if}
                        {if $show_department_option_new}
                        <td class="border1px">
                                <select name="SBdepartment" id="SBdepartment" size="20" disabled="disabled" class="disabled" onchange="">
                                {foreach $depts as $dept}
                                        <option value="{$dept.ID_DEPT}">{$dept.department}</option>
                                {/foreach}
                                </select>
                        </td>
                        {/if}
                        {if !$hide_functionprofile_option}
                        <td class="border1px" id="functionID"> {* dit id heeft de functie getFunctionList in select van department (hierboven) nodig *}
                                <select name="SBfunction" id="SBfunction" size="20" disabled="disabled" class="disabled">
                                {foreach $funcs as $func}
                                        <option value="{$func.ID_F}">{$func.function}</option>
                                {/foreach}
                                </select>
                        </td>
                        {/if}
                        {if $show_employees_bosses}
                        <td class="border1px" id="bossesID">
                                <select name="SBbosses[]" id="SBbosses" size="20" multiple="multiple" disabled="disabled" class="disabled" onchange="">
                                {foreach $bosses as $boss}
                                        <option value="{$boss.ID_E}">{$module_utils_object->BossName($boss.firstname, $boss.lastname)}</option>
                                {/foreach}
                                </select>
                        </td>
                        {/if}
                        {if $show_employees_bosses_new}
                        <td class="border1px" id="bossesID">
                                <select name="SBbosses[]" id="SBbosses" size="20" disabled="disabled" class="disabled" onchange="">
                                {foreach $bosses as $boss}
                                        <option value="{$boss.ID_E}">{$module_utils_object->BossName($boss.firstname, $boss.lastname)}</option>
                                {/foreach}
                                </select>
                        </td>
                        {/if}
                        <td class="border1px" >
                                {assign var='selectSize' value='20'}
                                {assign var='selectDivMarginTop' value='0'}
                                    <table border="0">
                                        {if 'CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT'|constant}
                                        {assign var='selectSize' value=$selectSize - 2}
                                        {assign var='selectDivMarginTop' value=$selectDivMarginTop + 2}
                                        <tr>
                                            <td><span>{'SEARCH_EMPLOYEE'|TXT_UCF}&nbsp;&nbsp;<input type="text" name="selempsearchtext" id="selempsearchtext" value="" onkeyup="empSearchEmployee(this);" /></span></td>
                                        </tr>
                                        {/if}
                                        {if 'CUSTOMER_OPTION_SHOW_EMPLOYEES_COUNT'|constant}
                                        {assign var='selectSize' value=$selectSize - 2}
                                        {assign var='selectDivMarginTop' value=$selectDivMarginTop + 2}
                                        <tr>
                                            {if 'CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT'|constant &&
                                                $emps|@count >= 'CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER'|constant}
                                            <td title="{'EMPLOYEES_LIST_LIMITED_RESULTS'|TXT_UCF}. {'ONLY_EMPLOYEES_LIMIT_SHOWN'|TXT_UCF_VALUE}">{'HEADCOUNT'|TXT_UCF}: <span id="employee_counter"><a>{$emps|@count} *</span></td>
                                            {else}
                                            <td>{'HEADCOUNT'|TXT_UCF}: <span id="employee_counter">{$emps|@count}</span></td>
                                            {/if}
                                        </tr>
                                        {/if}
                                    </table>
                                <div id="employeesID" style="margin-top: {$selectDivMarginTop}px">
                                    <select name="SBcross[]" id="SBcross" size="{$selectSize}" multiple="multiple">
                                    {foreach $emps as $emp}
                                            <option value="{$emp.ID_E}">{$module_utils_object->EmployeeName($emp.firstname, $emp.lastname)}</option>
                                    {/foreach}
                                    </select>
                                </div>
                        </td>
                </tr>
        </table>
</div>
<!-- /selectEmployees.tpl -->