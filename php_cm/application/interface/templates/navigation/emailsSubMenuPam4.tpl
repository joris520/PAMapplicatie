<!-- emailsSubMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
            <td class="clickable {activeClass menuName='MODULE_EMAIL_EXTERNAL_EMAILADDRESSES'}"
                onclick="xajax_moduleEmails_displayExternalEmailAddresses();return false;">
                <a href=""><strong>{'EXTERNAL_EMAIL_ADDRESSES'|TXT_TAB}</strong></a>
            </td>
            <td class="clickable {activeClass menuName='MODULE_EMAIL_360_NOTIFICATION_MESSAGE'}"
                onclick="xajax_moduleEmails_notification360Message();return false;">
                <a href=""><strong>{'360_NOTIFICATION_MESSAGE'|TXT_TAB}</strong></a>
            </td>
            <td class="clickable {activeClass menuName='MODULE_EMAIL_PDP_NOTIFICATION_MESSAGE'}"
                 onclick="xajax_moduleEmails_displayNotificationMessage();return false;">
                <a href=""><strong>{'PDP_NOTIFICATION_MESSAGE'|TXT_TAB}</strong></a>
            </td>
        </tr>
    </table>
</div>
<!-- /emailsSubMenuPam4.tpl -->
