<!-- mod_history_emps.tpl -->
{function name=getEmpMode emp_rating = 2}
{strip}
           {if $emp_rating == 1}
           {'RATING_DICTIONARY'|constant}
           {else}
           {'RATING_FUNCTION_PROFILE'|constant}
           {/if}
{/strip}
{/function}
                <div id="searchEmployeesLimit">
                    <p class="info-text">{if $showlimit}{'EMPLOYEES_LIST_LIMITED_RESULTS'|TXT_UCF}.<br />{'ONLY_EMPLOYEES_LIMIT_SHOWN'|TXT_UCF_VALUE}.{/if}</p>
                </div>
                <div id="scrollDiv">
                    <table border="0" cellspacing="0" cellpadding="1" style="width:280px;">
                    {foreach $employees as $employee}
                        <tr id="rowLeftNav{$employee.ID_E}" class="{if $history_id_e == $employee.ID_E}divLeftWbg{else}divLeftRow{/if}">
                            <td class="dashed_line ehp_window1">
                                <a href="" id="link{$employee.ID_E}" onclick="xajax_moduleHistory_showEmployeeHistory({$employee.ID_E}, '{getEmpMode emp_rating = $employee.rating}', 1); selectRow('rowLeftNav{$employee.ID_E}'); return false;">
                                    {$module_utils_object->EmployeeName($employee.firstname, $employee.lastname)}
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                    </table>
                 </div>
<!-- /mod_history_emps.tpl -->