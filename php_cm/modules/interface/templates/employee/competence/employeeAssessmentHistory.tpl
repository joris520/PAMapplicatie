<!-- employeeAssessmentHistory.tpl -->
{assign var=displayCycleId value='NULL'}
{assign var=isFirstCycle value=true}
{if $interfaceObject->getValueObjects()|count > 0}
{foreach $interfaceObject->getValueObjects() as $valueObject}
    {assign var=assessmentCycleValueObject value=$valueObject->getAssessmentCycleValueObject()}
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
                {'DATE_SAVED'|TXT_UCW}
            </th>
            <th class="bottom_line shaded_title form-label" style="width:150px;">
                {'CONVERSATION_DATE'|TXT_UCW}
            </td>
            {if $interfaceObject->isViewAllowedScoreStatus()}
            <th class="bottom_line shaded_title form-label" style="width:150px;">
                {'SCORE_STATUS'|TXT_UCF}
            </th>
            <th class="bottom_line shaded_title form-label">
                {'REMARKS'|TXT_UCF}
            </th>
            {/if}
        </tr>
        <tr style="text-align: left">
            <td class="bottom_line form-value">
                {DateTimeConverter::display($valueObject->getSavedDateTime())}<br/>{$valueObject->getSavedByUserName()}
            </td>
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getAssessmentDate(),$valueObject->getAssessmentDate())}">
                    {DateConverter::display($valueObject->getAssessmentDate())}
                </span>
            </td>
            {if $interfaceObject->isViewAllowedScoreStatus()}
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getScoreStatus(),$valueObject->getScoreStatus())}">
                    {ScoreStatusConverter::display($valueObject->getScoreStatus())}
                </span>
            </td>
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getAssessmentNote(),$valueObject->getAssessmentNote())}">
                    {$valueObject->getAssessmentNote()|nl2br}
                </span>
            </td>
            {/if}
        </tr>
        <tr>
            <td colspan="100%"><hr /></td>
        </tr>
    {assign var=compareValueObject value=$valueObject}{* voor de volgende loop onthouden *}
{/foreach}
{else}
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
    </table>
<!-- /employeeAssessmentHistory.tpl -->