<!-- selfAssessmentMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        {if $showBatchSelfAssessment}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH'}"
                onclick="xajax_public_batch_inviteSelfAssessment();return false;">
                <a href="">{'MENU_INVITATION_SELF_ASSESSMENT'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showBatchSelfAssessmentReminders}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH'}"
                onclick="xajax_public_batch_remindSelfAssessment();return false;">
                <a href="">{'MENU_REMINDER_SELF_ASSESSMENT'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showOverviewSelfAssessmentInvitations}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS'}"
                onclick="xajax_public_report__displayInvitations();return false;">
                <a href="">{'MENU_REPORT_SELFASSESSMENT_INVITATIONS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardSelfAssessments}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS'}"
                onclick="xajax_public_report__displayInvitationDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_ASSESSMENT_COMPLETED'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDashboardAssessmentProcess}
            <td class="clickable {activeClass menuName='MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS'}"
                onclick="xajax_public_report__displayProcessDashboard();return false;">
                <a href="">{'MENU_DASHBOARD_ASSESSMENT_PROCESS'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /selfAssessmentMenuPam4.tpl -->
