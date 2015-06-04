<!-- settingsMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        {if $showLevelAuthorization}
            <td class="clickable {activeClass menuName='MODULE_LEVEL_AUTHORIZATION'}"
                onclick="xajax_moduleLevelAuthorisation_displayLevelAuthorization();return false;">
                <a href="" >{'LEVEL_AUTHORIZATION'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showUsers}
            <td class="clickable {activeClass menuName='MODULE_USERS'}"
                onclick="xajax_moduleUsers();return false;">
                <a href="">{'USERS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showThemes}
            <td class="clickable {activeClass menuName='MODULE_THEMES'}"
                onclick="xajax_moduleOptions_themeLogo();return false;">
                <a href="">{'THEMES'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDefaultDate}
            <td class="clickable {activeClass menuName='MODULE_DEFAULT_DATE'}"
                onclick="xajax_public_settings__displayStandardDate();return false;">
                <a href="">{'DEFAULT_END_DATE'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmpArchives}
            <td class="clickable {activeClass menuName='MODULE_EMPLOYEES_ARCHIVED'}"
                onclick="xajax_moduleOptions_showEmployeesArchive();return false;">
                <a href="">{'EMPLOYEE_ARCHIVES'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /settingsMenuPam4.tpl -->