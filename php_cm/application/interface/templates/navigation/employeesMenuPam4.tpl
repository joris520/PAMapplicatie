<!-- employeesMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu">
    {if $noEmployee}
    <div class="tab-menu" style="padding:9px 15px;">
        <h2 style="margin:0px; padding:0px">&nbsp;{TXT_UCF('SELECT_EMPLOYEES')}</h2>
    </div>
    {else}
    <table class="tab-menu">
        <tr>
        {if $showEmployeeProfile}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_PROFILE'}"
                onclick="xajax_public_employeeProfile__displayPage({$employeeId});return false;">
                <a href="">{'EMPLOYEE_PROFILE'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeAttachments}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_ATTACHMENTS'}"
                onclick="xajax_public_employeeDocument__displayPage({$employeeId});return false;">
                <a href="">{'ATTACHMENTS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeScore}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_SCORE'}"
                onclick="xajax_public_employeeCompetence__displayPage({$employeeId});return false;">
                <a href="">{'CUSTOMER_SCORE_TAB_LABEL'|constant|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeePdpActions}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_PDP_ACTIONS'}"
                onclick="xajax_public_employeePdpAction__displayPage({$employeeId});return false;">
                <a href="">{'PDP_ACTIONS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeTargets}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_TARGETS'}"
                onclick="xajax_public_employeeTarget__displayEmployeeTargets({$employeeId});return false;">
                <a href="" >{'CUSTOMER_TARGETS_TAB_LABEL'|constant|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeFinalResult}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_FINAL_RESULTS'}"
                onclick="xajax_public_employeeFinalResult__displayFinalResult({$employeeId});return false;">
                <a href="">{'FINAL_RESULT'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeTraining}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_TRAINING'}"
                onclick="xajax_public_employeeTraining__displayTraining({$employeeId});return false;">
                <a href="">{'TRAINING'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployee360}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_360'}"
                onclick="xajax_moduleEmployees_360_menu_deprecated({$employeeId});return false;">
                <a href="">{if 'CUSTOMER_OPTION_USE_SELFASSESSMENT'|constant}{'SELF_ASSESSMENT'|TXT_TAB}{else}360&deg;{/if}</a>
            </td>
        {/if}
        {if $showEmployeeHistory}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_HISTORY'}"
                onclick="xajax_moduleEmployees_history_menu_deprecated({$employeeId}, 'function');return false;">
                <a href="">{'TAB_HISTORY'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmployeeInvitations}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_INVITATIONS'}"
                onclick="xajax_public_employeeAssessmentInvitation__displayPage({$employeeId});return false;">
                <a href="">{'VIEW_INVITATIONS'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
    {/if}
</div>
<!-- /employeesMenuPam4.tpl -->