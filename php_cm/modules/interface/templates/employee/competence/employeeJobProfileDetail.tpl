<!-- employeeJobProfileDetail.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=mainFunction value=$valueObject->getMainFunction()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td>
            {strip}
            <p>
                <strong>{'BASED_ON_JOB_PROFILE'|TXT_UCF}:</strong>
                &nbsp;{$mainFunction->getFunctionName()}
            </p>
            {if $valueObject->hasAdditionalFunctions()}
            <p>
                <strong>{'ADDITIONAL_JOB_PROFILES'|TXT_UCF}&nbsp;{'SIGN_COMP_ADDITIONAL_PROFILE'|constant}:</strong>
                &nbsp;{$interfaceObject->getAdditionalFunctionsList()}
            </p>
            {/if}
            {/strip}
        </td>
        <td style="width:{$interfaceObject->getActionsWidth()}px; text-align:right">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
</table>
<!-- /employeeJobProfileDetail.tpl -->