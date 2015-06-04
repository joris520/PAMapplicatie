<!-- pdpActionEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="cluster_id">{'CLUSTER'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input type="radio"  id="cluster_selector_1" name="cluster_selector" value="{PdpActionClusterSelectorState::USE_EXISTING_CLUSTER}"  checked="checked">
            <select id="cluster_id" name="cluster_id"
                    onChange="selectRadioValue('cluster_selector_1');return false;" >
                {include    file='components/selectIdValuesComponent.tpl'
                            idValues=$interfaceObject->getClusterIdValues()
                            currentValue=$valueObject->getClusterId()
                            required=false
                            subject='CLUSTER'|TXT_LC}
            </select>
        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value">
            <input type="radio" id="cluster_selector_2" name="cluster_selector" value="{PdpActionClusterSelectorState::CREATE_NEW_CLUSTER}">
            {'ADD_NEW_CLUSTER'|TXT_LC}&nbsp;
            <input  id="cluster_name" name="cluster_name" type="text" size="30" value=""
                    onKeyUp="selectRadioValue('cluster_selector_2');return false;"
                    onChange="selectRadioValue('cluster_selector_2');return false;">
        </td>
    </tr>
    <tr>
        <td colspan="100%">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="action_name">{'PDP_ACTION'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="action_name" name="action_name" type="text" size="60" value="{$valueObject->getActionName()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="provider">{'PROVIDER'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="provider" name="provider" type="text" size="60" value="{$valueObject->getProvider()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="duration">{'DURATION'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="duration" name="duration" type="text" size="30" value="{$valueObject->getDuration()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="cost">{'COST'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            &euro; <input  id="cost" name="cost" type="text" size="20" value="{$valueObject->getCost()}">
        </td>
    </tr>

</table>
{if $valueObject->getId()}
<br>
<table cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            {'APPLY_TO'|TXT_UCF}
        </td>
        <td class="form-value">
            <input type="radio" name="apply_to" value="{PdpActionApplyToState::APPLY_TO_NEW}" checked="checked">
            {'APPLY_ONLY_TO_NEW_EMPLOYEE_ACTIONS'|TXT_UCF}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value">
            <input type="radio" name="apply_to" value="{PdpActionApplyToState::APPLY_TO_EXISTING}">
            {'APPLY_TO_EXISTING_EMPLOYEE_ACTIONS'|TXT_UCF}
        </td>
    </tr>
</table>
{/if}
<!-- /pdpActionEdit.tpl -->

