<!-- helpMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu">
    <table class="tab-menu">
        <tr>
        {if $showInfo}
            <td class="clickable {activeClass menuName='MODULE_INFO'}"
                onclick="xajax_modulePAMInfo();return false;">
                <a href="">{'SYSTEM_VERSION_INFORMATION'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showTechManual}
            <td class="clickable {activeClass menuName='MODULE_TECH_MANUAL'}"
                onclick="xajax_moduleTechnicalManual();return false;">
                <a href="">{'TECHNICAL_MANUAL'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showUserManual}
            <td class="clickable {activeClass menuName='MODULE_USER_MANUAL'}"
                onclick="xajax_moduleUserManual();return false;">
                <a href="">{'USER_MANUAL'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /helpMenuPam4.tpl -->