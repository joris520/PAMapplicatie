<!-- employeeTargetHistory.tpl -->
{assign var=displayCycleId value='NULL'}
{assign var=isFirstCycle value=true}
{if $interfaceObject->getValueObjects()|count > 0}
{foreach $interfaceObject->getValueObjects() as $valueObject}
    {assign var=assessmentCycleValueObject value=$valueObject->getAssessmentCycleValueObject()}
    {assign var=cycleName value=$assessmentCycleValueObject->getAssessmentCycleName()}
    {if $displayCycleId != $assessmentCycleValueObject->getId()}
    {if !$isFirstCycle}
    </table>
    {/if}
    {* de vorige compare resetten bij een nieuwe cyclus *}
    {assign var=compareValueObject value=$valueObject}

    {include    file='components/historyAssessmentCycleDetail.tpl'
                displayWidth=$interfaceObject->getDisplayWidth()
                assessmentCycleValueObject=$assessmentCycleValueObject}

    <table cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    {/if}
    {assign var=isFirstCycle value=false}
    {assign var=displayCycleId value=$assessmentCycleValueObject->getId()}
    <tr style="text-align: left">
        <th class="bottom_line form-label" style="width:200px;">
            {'DATE_SAVED'|TXT_UCF}
        </th>
        <th class="bottom_line form-label shaded_title" style="width:200px">
            {'TARGET'|TXT_UCF}
        </th>
        <td class="bottom_line form-label shaded_title" >
            {'KPI'|TXT_UCF}
        </td>
        <th class="bottom_line form-label shaded_title" style="width:100px">
            {'TARGET_END_DATE'|TXT_UCF}
        </th>
        {if $interfaceObject->isViewAllowedEvaluation()}
        <th class="bottom_line form-label shaded_title" style="width:175px">
            {'TARGET_STATUS'|TXT_UCF}
        </th>
        {/if}
    </tr>
    <tr style="text-align: left">
        <td class="form-value">
            {DateTimeConverter::display($valueObject->getSavedDateTime())}
            <br/>
            {$valueObject->getSavedByUserName()}
        </td>
        <td class="form-value">
            <span class="{$interfaceObject->diff($compareValueObject->getTargetName(),$valueObject->getTargetName())}">
                {$valueObject->getTargetName()}
            </span>
        </td>
        <td class="form-value">
            <span class="{$interfaceObject->diff($compareValueObject->getPerformanceIndicator(),$valueObject->getPerformanceIndicator())}">
                {$valueObject->getPerformanceIndicator()}
            </span>
        </td>
        <td class="form-value">
            <span class="{$interfaceObject->diff($compareValueObject->getEndDate(),$valueObject->getEndDate())}">
                {DateUtils::convertToDisplayDate($valueObject->getEndDate())}
            </span>
        </td>
        {if $interfaceObject->isViewAllowedEvaluation()}
        <td class="form-value">
            <span class="{$interfaceObject->diff($compareValueObject->getStatus(),$valueObject->getStatus())}">
                {EmployeeTargetStatusConverter::image($valueObject->getStatus())}&nbsp;{EmployeeTargetStatusConverter::display($valueObject->getStatus())}
            </span>
        </td>
        {/if}
    </tr>
    {if $interfaceObject->isViewAllowedEvaluation()}
    {assign var=evaluationDate  value=$valueObject->getEvaluationDate()}
    {if !empty($evaluationDate)}
    <tr>
        <td class="form-value"></td>
        <th class="content-title remarks-title">{'CONVERSATION_DATE'|TXT_UCF}</th>
        <td class="content-line" colspan="100%">
            <span class="{$interfaceObject->diff($compareValueObject->getEvaluationDate(),$evaluationDate)}">
                {DateUtils::convertToDisplayDate($valueObject->getEvaluationDate())}
            </span>
        </td>
    </tr>
    {/if}
    {assign var=evaluation      value=$valueObject->getEvaluation()}
    {if !empty($evaluation)}
    <tr>
        <td class="form-value"></td>
        <th class="content-title remarks-title">{'EVALUATION'|TXT_UCF}</th>
        <td class="content-line" colspan="100%">
            <span class="{$interfaceObject->diff($compareValueObject->getEvaluation(),$evaluation)}">
                {$evaluation|nl2br}
            </span>
        </td>
    </tr>
    {/if}
    {/if}
    <tr>
        <td class="bottom_line" colspan="100%"><hr /></td>
    </tr>
    {assign var=compareValueObject value=$valueObject}{* voor de volgende loop onthouden *}
{/foreach}
{else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
</table>
<!-- /employeeTargetHistory.tpl -->