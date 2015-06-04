<!-- applicationMenu.tpl -->
{function name=writeName labelName='' menuName=''}
{strip}
    {if $active == $menuName|constant}<span class="activated">{/if}
        {$labelName|TXT_UCW}
    {if $active == $menuName|constant}</span>{/if}
{/strip}
{/function}
{strip}
{if $showEmployees}
    <a href="" onclick="xajax_public_navigation_applicationMenu_employees();return false;">{writeName labelName='EMPLOYEES' menuName='APPLICATION_MENU_EMPLOYEES'}</a>
{/if}
{if $showDashboard}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_dashboard();return false;">{writeName labelName='MENU_DASHBOARD' menuName='APPLICATION_MENU_DASHBOARD'}</a>
{/if}
{if $showSelfAssessment}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_selfAssessment();return false;">{writeName labelName='SELF_ASSESSMENT' menuName='APPLICATION_MENU_SELFASSESSMENT'}</a>
{/if}
{if $showOrganisation}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_organisation();return false;">{writeName labelName='ORGANISATION' menuName='APPLICATION_MENU_ORGANISATION'}</a>
{/if}
{if $showReports}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_reports();return false;">{writeName labelName='REPORTS' menuName='APPLICATION_MENU_REPORTS'}</a>
{/if}
{if $showLibraries}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_library();return false;">{writeName labelName='LIBRARIES' menuName='APPLICATION_MENU_LIBRARIES'}</a>
{/if}
{if $showSettings}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_settings();return false;">{writeName labelName='SETTINGS' menuName='APPLICATION_MENU_SETTINGS'}</a>
{/if}
{if $showHelp}
    &nbsp;|&nbsp;
    <a href="" onclick="xajax_public_navigation_applicationMenu_help();return false;">{writeName labelName='HELP' menuName='APPLICATION_MENU_HELP'}</a>
{/if}
{if $showHome || $showEmployees || $showOrganisation ||$showReports || $showLibraries || $showSettings || $showHelp}
&nbsp;&nbsp;
<br />
{/if}
<span style="color: #666; line-height:30px;">
    <span title="{'USER_LEVEL'|TXT_UCF}: {$USER_LEVEL_NAME}">
        {if !'APPLICATION_IS_PRODUCTION_ENVIRONMENT'|constant}
            <span class="clickable" onClick="toggleVisilibityById('environment_info'); return false;">
        {/if}
        <strong>{$USER}</strong>
        {if !'APPLICATION_IS_PRODUCTION_ENVIRONMENT'|constant}
            </span>
        {/if}
    </span>
    {if PamApplication::isAllowedSwitchUserLevel()}
    <span title="{'SWITCH_USER_LEVEL'|TXT_UCF}">
        &nbsp;&nbsp;
        [<span style="font-weight:normal; font-style:italic;">
            <a href="" onClick="xajax_public_application_toggleUserLevel();return false;">
                {$USER_LEVEL_NAME}&nbsp;<img src="{'ICON_EDIT'|constant}">
            </a>
        </span>]
    </span>
    {/if}
    &nbsp;|&nbsp;
{if $showChangePassword}
    <a href="" title="{'CHANGE_PASSWORD'|TXT_UCF}" onclick="xajax_public_application_changePassword();return false;">&nbsp;{'APPLICATION_MENU_PASSWORD'|TXT_UCW}</a>
{/if}
    &nbsp;|&nbsp;
{if $showLogOut}
    <a href="" onclick="xajax_moduleLogin_logOut();return false;">&nbsp;{'LOG_OUT'|TXT_UCW}</a>
{/if}
    &nbsp;&nbsp;
</span>
{if !'APPLICATION_IS_PRODUCTION_ENVIRONMENT'|constant}
<div id="environment_info" style="width:100%; background-color:{'ENVIRONMENT_COLOR'|constant}; padding: 3px 0px;">
{if $showReferenceDateEditor}
<form id="{$editorFormName}" name="{$editorFormName}">
{$referenceDateEditor}
{/if}
&nbsp;>>&nbsp;{$COMPANY_NAME}&nbsp;<span style="font-weight:normal; font-style:italic;">{$USER_LEVEL_NAME}</span>&nbsp;-&nbsp;{'ENVIRONMENT_DETAIL'|constant} <<&nbsp;&nbsp;
{if $showReferenceDateEditor}
</form>
{/if}
</div>
{/if}
{/strip}
<!-- /applicationMenu.tpl -->