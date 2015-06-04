<!-- employeeJobProfileView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=mainFunction value=$valueObject->getMainFunction()}
<table  class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td width="200" class="content-label">
            {'BASED_ON_JOB_PROFILE'|TXT_UCF} :
        </td>
        <td class="content-value">
            {$mainFunction->getFunctionName()}
        </td>
    </tr>
    {if $valueObject->hasAdditionalFunctions()}
    {assign var=additionalFunctions value=$valueObject->getAdditionalFunctions()}
    <tr>
        <td width="200" class="content-label">
            {'ADDITIONAL_JOB_PROFILES'|TXT_UCF} :
        </td>
        <td class="content-value info-list">
            <ul>
                {foreach $additionalFunctions as $additionalFunction}
                <li>
                    {$additionalFunction->getFunctionName()}
                </li>
                {/foreach}
            </ul>
        </td>
    </tr>
    {/if}
    {if $valueObject->hasNote()}
    <tr>
        <td class="content-label">{'REMARKS'|TXT_UCF} :</td>
        <td class="content-value">{$valueObject->getNote()}</td>
    </tr>
    {/if}
</table>
<!-- /employeeJobProfileView.tpl -->