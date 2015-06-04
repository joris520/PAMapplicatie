<!-- employeeTargetView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=endDate     value=$valueObject->getEndDate()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='short_hilite'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}
<tr class="{$new_row_indicator} row_employee_target" id="target_row_{$valueObject->getId()}">
    <td class="">
        {$valueObject->getTargetName()}
    </td>
    <td class="">
        {$valueObject->getPerformanceIndicator()}
    </td>
    {if $interfaceObject->isViewAllowedEvaluation()}
        <td class="" id="target_status_inline_{$valueObject->getId()}">
            {EmployeeTargetStatusConverter::image($valueObject->getStatus())}&nbsp;{EmployeeTargetStatusConverter::display($valueObject->getStatus())}
        </td>
    {/if}
    <td class="{if $interfaceObject->hasDateWarning()}warning-text{/if}">
        {DateConverter::display($valueObject->getEvaluationDate())}
    </td>
    <td class="actions">
        {$interfaceObject->getEditLink()}{$interfaceObject->getRemoveLink()}{$interfaceObject->getHistoryLink()}
    </td>
</tr>
{if $interfaceObject->isViewAllowedEvaluation()}
{assign var=evaluationDate value=$valueObject->getEvaluationDate()}
{assign var=evaluation value=$valueObject->getEvaluation()}
{if !empty($evaluationDate) || !empty($evaluation)}
    <tr>
        <td class="">
            &nbsp;
        </td>
        <td colspan="4" style="padding-left:0px; padding-right:0px;">
            <div class="remarks-content" style=" padding:10px;">

                {if !empty($evaluationDate)}
                <strong>{'CONVERSATION_DATE'|TXT_LC}</strong>
                <br />
                <span class="comment">
                    {DateConverter::display($evaluationDate)}
                </span>
                <br />
                {if  !empty($evaluation)}
                <br />
                {/if}
                {/if}
                {if !empty($evaluation)}
                <strong>{'EVALUATION'|TXT_LC}</strong>
                <br />
                <span class="comment">
                    {$evaluation|nl2br}
                </span>
                {/if}
            </div>
        </td>
        <td class="">
            &nbsp;
        </td>
    </tr>
{/if}
<tr>
    <td colspan="100%" class="bottom_line"></td>
</tr>
{/if}
<!-- /employeeTargetView.tpl -->