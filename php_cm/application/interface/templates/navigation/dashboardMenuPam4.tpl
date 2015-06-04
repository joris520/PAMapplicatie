<!-- dashboardMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        {if $showDepartments}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DEPARTMENTS'}"
                onclick="xajax_public_dashboard__displayDepartments();return false;">
                <a href="">{'DEPARTMENTS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showManagers}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_MANAGERS'}"
                onclick="xajax_public_dashboard__displayManagers();return false;">
                <a href="">{'REPORT_MANAGERS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardPdpActions}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS'}"
                onclick="xajax_public_dashboard__displayPdpActionDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_PDP_ACTIONS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardTargets}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS'}"
                onclick="xajax_public_dashboard__displayTargetDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_PREFIX'|TXT_TAB}&nbsp;{'CUSTOMER_TARGETS_TAB_LABEL'|constant|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardFinalResult}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT'}"
                onclick="xajax_public_dashboard__displayFinalResultDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_FINAL_RESULT'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardTraining}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING'}"
                onclick="xajax_public_dashboard__displayTrainingDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_TRAINING'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showOverviewSelfAssessmentInvitations}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS'}"
                onclick="xajax_public_dashboard__displayInvitations();return false;">
                <a href="">{'MENU_REPORT_SELFASSESSMENT_INVITATIONS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardSelfAssessments}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS'}"
                onclick="xajax_public_dashboard__displayInvitationDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_ASSESSMENT_COMPLETED'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardAssessmentProcess}
            <td class="clickable {activeClass menuName='MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS'}"
                onclick="xajax_public_dashboard__displayProcessDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_ASSESSMENT_PROCESS'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /dashboardMenuPam4.tpl -->
