<!-- reportsMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        {if $showSelfAssessmentReports}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_REPORTS'}"
                onclick="xajax_moduleOrganisation_selfassessmentReportsForm();return false;">
                <a href="">{'SELFASSESSMENT_REPORTS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showScoreboard}
            <td class="clickable {activeClass menuName='MODULE_SCOREBOARD'}"
                onclick="xajax_moduleScoreboard_calc(0);return false;">
                <a href="">{'SCOREBOARD'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showTalentSelector}
            <td class="clickable {activeClass menuName='MODULE_TALENT_SELECTOR'}"
                onclick="xajax_public_report__displayTalentSelector();return false;">
                <a href="">{'TALENT_SELECTOR'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showPerformanceGrid}
            <td class="clickable {activeClass menuName='MODULE_PERFORMANCE_GRID'}"
                onclick="xajax_modulePerformanceGrid_displayPerformanceGrid();return false;">
                <a href="">{'PERFORMANCE_GRID'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showPrintPortfolio}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEE_PORTFOLIO'}"
                onclick="xajax_moduleEmployeesPrints_printEmployeesFullPortfolio_deprecated();return false;">
                <a href="">{'EMPLOYEES'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showHistory}
            <td class="clickable {activeClass menuName='MODULE_HISTORY'}"
                onclick="xajax_moduleHistory_menu();return false;">
                <a href="">{'TAB_HISTORY'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showManagers}
            <td class="clickable {activeClass menuName='MODULE_REPORTS_MANAGER'}"
                onclick="xajax_public_report__displayManagers();return false;">
                <a href="">{'REPORT_MANAGERS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $show360}
            <td class="clickable {activeClass menuName='MODULE_360'}"
                onclick="xajax_module360_display360Employees();return false;">
                <a href="">{if 'CUSTOMER_OPTION_USE_SELFASSESSMENT'|constant}{'REPORT_MENU_SELF_ASSESSMENT'|TXT_TAB}{else}360&deg;{/if}</a>
            </td>
        {/if}
        {if $showPdpTodoList}
            <td class="clickable {activeClass menuName='MODULE_PDP_TODO_LIST'}"
                onclick="xajax_modulePDPToDoList();return false;">
                <a href="">{'PDP_TODO_LIST'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showNotificationAlerts}
            <td class="clickable {activeClass menuName='MODULE_EMAIL_PDP_NOTIFICATION_ALERTS'}"
                onclick="xajax_moduleEmails_showPDPActionsNotificationAlerts();return false;">
                <a href=""><strong>{'PDP_NOTIFICATION_MESSAGE_ALERTS'|TXT_TAB}</strong></a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /reportsMenuPam4.tpl -->