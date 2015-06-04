<!-- adminMenu.tpl -->
{strip}
<a href="" onclick="xajax_moduleCustomers_displayCustomers();return false;"><span class="activated">Klantbeheer</span></a>
&nbsp;|&nbsp;
<a href="" onclick="xajax_moduleLogin_logOut();return false;">Uitloggen</a>
&nbsp;&nbsp;<br />
<span style="color: #666; line-height:30px;">
    <span>
        <strong>{$USER}</strong>&nbsp;
        [<span style="font-weight:normal;font-style:italic;">{$USER_LEVEL_NAME}</span>]
    </span>
    &nbsp;&nbsp;
</span>
{if !'APPLICATION_IS_PRODUCTION_ENVIRONMENT'|constant}
<div style="width:100%; background-color:{'ENVIRONMENT_COLOR'|constant}; padding:3px;">
    Omgeving: >> {'ENVIRONMENT_DETAIL'|constant} << &nbsp;&nbsp;
</div>
{/if}
{/strip}

<!-- /adminMenu.tpl -->