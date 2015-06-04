<!-- themesSubMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
            <td class="clickable {activeClass menuName='MODULE_THEMES_LOGO'}"
                onclick="xajax_moduleOptions_themeLogo();return false;">
                <a href=""><strong>{'LOGO'|TXT_TAB}</strong></a>
            </td>
        {if $showColour}
            <td class="clickable {activeClass menuName='MODULE_THEMES_COLOUR'}"
                onclick="xajax_moduleOptions_editThemeColour();return false;">
                <a href=""><strong>{'THEME_COLOUR'|TXT_TAB}</strong></a>
            </td>
        {/if}
            <td class="clickable {activeClass menuName='MODULE_THEMES_LANGUAGE'}"
                onclick="xajax_moduleOptions_editThemeLanguage();return false;">
                <a href=""><strong>{'LANGUAGE'|TXT_TAB}</strong></a>
            </td>
        </tr>
    </table>
</div>
<!-- /themesSubMenuPam4.tpl -->