<!-- employeePdpActionUserDefinedEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="1" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:130px;">
            {'EMPLOYEE'|TXT_UCF}
        </td>
        <td class="form-value">
            {EmployeeNameConverter::display($valueObject->getEmployeeFirstName(), $valueObject->getEmployeeLastName())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'DEPARTMENT'|TXT_UCF}
        </td>
        <td>
            {$valueObject->getDepartmentName()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'MANAGER'|TXT_UCF}
        </td>
        <td class="form-value">
            {EmployeeNameConverter::display($valueObject->getBossFirstName(), $valueObject->getBossLastName())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'DEADLINE_DATE'|TXT_UCF}
        </td>
        <td class="form-value {if $interfaceObject->hasDateWarning()}warning-text{/if}">
            {DateConverter::display($valueObject->getTodoBeforeDate())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'COMPLETED'|TXT_UCF}
        </td>
        <td class="form-value">
            {PdpActionCompletedConverter::image($valueObject->getIsCompletedStatus())}
        </td>
    </tr>
</table>
<br/>
<table border="0" cellspacing="1" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td colspan="100%">
            {$interfaceObject->getPdpActionLibrarySelector()->fetchHtml()}
        </td>
    </tr>
    <tr>
        <td class="form-label" style="width:100px;">
            {'PDP_ACTION'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}
        </td>
        <td class="form-value" style="width:300px;">
            <input type="text" size="60" id="fill_action" name="fill_action" value="{$valueObject->getUserDefinedActionName()}"/>
        </td>
        <td class="form-value" style="width:30px;">
            {if $valueObject->isCustomerLibrary()}
            <input type="hidden" id="hidden_action" value="{$valueObject->getLibraryActionName()}">
            <a href="" onClick="document.getElementById('fill_action').value=document.getElementById('hidden_action').value;return false;">&nbsp;&laquo;&nbsp;</a>
            {else}
            &nbsp;
            {/if}
        </td>
        <td class="form-value" style="width:300px;">
            {strip}
            <span id="show_action">
            {if $valueObject->isCustomerLibrary()}
            {$valueObject->getLibraryActionName()}
            {else}
            &nbsp;
            {/if}
            </span>
            {/strip}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'PROVIDER'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}
        </td>
        <td class="form-value">
            <input type="text" size="60" id="fill_provider" name="fill_provider" value="{$valueObject->getUserDefinedProvider()}"/>
        </td>
        <td class="form-value">
            {if $valueObject->isCustomerLibrary()}
            <input type="hidden" id="hidden_provider" value="{$valueObject->getLibraryProvider()}">
            <a href="" onClick="document.getElementById('fill_provider').value=document.getElementById('hidden_provider').value;return false;">&nbsp;&laquo;&nbsp;</a>
            {else}
            &nbsp;
            {/if}
        </td>
        <td class="form-value">
            {strip}
            <span id="show_provider">
            {if $valueObject->isCustomerLibrary()}
            {$valueObject->getLibraryProvider()}
            {else}
            &nbsp;
            {/if}
            </span>
            {/strip}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'DURATION'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}
        </td>
        <td class="form-value">
            <input type="text" size="30" id="fill_duration" name="fill_duration" value="{$valueObject->getUserDefinedDuration()}"/>
        </td>
        <td class="form-value">
            {if $valueObject->isCustomerLibrary()}
            <input type="hidden" id="hidden_duration" value="{$valueObject->getLibraryDuration()}">
            <a href="" onClick="document.getElementById('fill_duration').value=document.getElementById('hidden_duration').value;return false;">&nbsp;&laquo;&nbsp;</a>
            {else}
            &nbsp;
            {/if}
        </td>
        <td class="form-value">
            {strip}
            <span id="show_duration">
            {if $valueObject->isCustomerLibrary()}
            {$valueObject->getLibraryDuration()}
            {else}
            &nbsp;
            {/if}
            </span>
            {/strip}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'COST'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}
        </td>
        <td class="form-value">
            &euro;&nbsp;<input type="text" size="20" id="fill_cost" name="fill_cost" value="{PdpCostConverter::input($valueObject->getUserDefinedCost())}"/>
        </td>
        <td class="form-value">
            {if $valueObject->isCustomerLibrary()}
            <input type="hidden" id="hidden_cost" value="{$valueObject->getLibraryCost()}">
            <a href="" onClick="document.getElementById('fill_cost').value=document.getElementById('hidden_cost').value;return false;">&nbsp;&laquo;&nbsp;</a>
            {else}
            &nbsp;
            {/if}
        </td>
        <td class="form-value">
            {strip}
            <span id="show_cost">
            {if $valueObject->isCustomerLibrary()}
            {PdpCostConverter::display($valueObject->getLibraryCost())}
            {else}
            &nbsp;
            {/if}
            </span>
            {/strip}
        </td>
    </tr>
</table>
<!-- /employeePdpActionUserDefinedEdit.tpl -->