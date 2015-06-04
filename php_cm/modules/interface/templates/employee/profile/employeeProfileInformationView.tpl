<!-- employeeProfileInformationView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=styleLabelWidth value='style="width:220px;"'}
<table  class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};">
    {assign var=educationLevel value=$valueObject->getEducationLevel()}
    {if !empty($educationLevel)}
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'EDUCATION_LEVEL'|TXT_UCF}:</td>
        <td class="content-value">{EmployeeEducationLevelConverter::display($educationLevel)}</td>
    </tr>
    {/if}
    {assign var=additionalInfo value=$valueObject->getAdditionalInfo()}
    {if !empty($additionalInfo)}
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'ADDITIONAL_INFO'|TXT_UCF}:</td>
        <td class="content-value">{$additionalInfo|nl2br}</td>
    </tr>
    {/if}
    {if $interfaceObject->isAllowedShowManagerInfo()}
    {assign var=managerInfo value=$valueObject->getManagerInfo()}
    {if !empty($managerInfo)}
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'MANAGERS_COMMENTS'|TXT_UCF}:</td>
        <td class="content-value">{$managerInfo|nl2br}</td>
    </tr>
    {/if}
    {/if}
    {if empty($educationLevel) && empty($additionalInfo) && empty($managerInfo)}
    <tr>
        <td colspan="2" class="content-label info-text">{'NO_ADDITIONAL_INFO'|TXT_UCF}</td>
    </tr>
    {/if}
</table>
<!-- /employeeProfileInformationView.tpl -->