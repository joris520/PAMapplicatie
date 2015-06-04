<!-- employeeProfileUserView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=styleLabelWidth value='style="width:220px;"'}
<table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};">
    {if $interfaceObject->hasUser()}
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'USERNAME'|TXT_UCF}:</td>
        <td class="content-value"><span{if !$valueObject->isActive()} class="inactive" title="{'DEACTIVATED_USER'|TXT_UCF}"{/if}>{$valueObject->getLogin()}</span>{if !$valueObject->isActive()}&nbsp;<em>{'DEACTIVATED_USER'|TXT_UCF}</em>{/if}</td>
    </tr>
    <tr>
        <td class="content-label">{'SECURITY'|TXT_UCF}:</td>
        <td class="content-value">{UserLevelConverter::display($valueObject->getUserLevel())}</td>
    </tr>
    {else}
    <tr>
        <td colspan="2" class="content-label info-text">{'NO_EMPLOYEE_USER_LINK'|TXT_UCF}.</td>
    </tr>
    {/if}
</table>
<!-- /employeeProfileUserView.tpl -->