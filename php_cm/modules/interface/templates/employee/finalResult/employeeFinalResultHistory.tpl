<!-- employeeFinalResultHistory.tpl -->
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
            <th class="bottom_line form-label" style="width:150px;">
                {'CONVERSATION_DATE'|TXT_UCW}
            </th>
            <td class="bottom_line form-value" style="width:150px;">
                <span class="{$interfaceObject->diff($compareValueObject->getAssessmentDate(),$valueObject->getAssessmentDate())}">
                    {DateConverter::display($valueObject->getAssessmentDate())}
                </span>
            </td>
            {if $showRemarks}
            <th class="bottom_line">&nbsp;</th>
            {/if}
        </tr>
        <tr style="text-align: left">
            <td class="bottom_line form-value">
                {DateTimeConverter::display($valueObject->getSavedDateTime())}
            </td>
            <th class="bottom_line shaded_title form-label">
                {'FINAL_RESULT'|TXT_UCW}
            </th>
            <th class="bottom_line shaded_title form-label centered">
                {'CUSTOMER_MGR_SCORE_LABEL'|constant|TXT_UCF}
            </th>
            {if $interfaceObject->showRemarks()}
            <th class="bottom_line shaded_title form-label">
                {'REMARKS'|TXT_UCF}
            </th>
            {/if}
        </tr>
        <tr>
            <td class="bottom_line">
                {$valueObject->getSavedByUserName()}
            </td>
            <td class="bottom_line form-label">
                {'TOTAL_RESULT'|TXT_UCF}
            </td>
            <td class="bottom_line form-value centered">
                <span class="{$interfaceObject->diff($compareValueObject->getTotalScore(),$valueObject->getTotalScore())}">
                    {TotalScoreConverter::display($valueObject->getTotalScore())}
                <span>
            </td>
            {if $interfaceObject->showRemarks()}
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getTotalScoreComment(),$valueObject->getTotalScoreComment())}">
                    <span class="comment">{$valueObject->getTotalScoreComment()|nl2br}</span>
                </span>
            </td>
            {/if}
        </tr>
        {if $interfaceObject->showDetailScores()}
        <tr>
            <td class="bottom_line" style="width:20%">&nbsp;</td>
            <td class="bottom_line form-label" style="padding-left:30px;">
                {'BEHAVIOUR'|TXT_UCF}
            </td>
            <td class="bottom_line form-value centered">
                <span class="{$interfaceObject->diff($compareValueObject->getBehaviourScore(),$valueObject->getBehaviourScore())}">
                    {ScoreConverter::display($valueObject->getBehaviourScore())}
                </span>
            </td>
            {if $interfaceObject->showRemarks()}
            <td class="bottom_line">
                <span class="{$interfaceObject->diff($compareValueObject->getBehaviourScoreComment(),$valueObject->getBehaviourScoreComment())}">
                    <span class="comment">{$valueObject->getBehaviourScoreComment()|nl2br}</span>
                </span>
            </td>
            {/if}
        </tr>
        <tr>
            <td class="bottom_line">&nbsp;</td>
            <td class="bottom_line form-label" style="padding-left:30px;">
                {'RESULTS'|TXT_UCF}
            </td>
            <td class="bottom_line form-value centered">
                <span class="{$interfaceObject->diff($compareValueObject->getResultsScore(),$valueObject->getResultsScore())}">
                    {ScoreConverter::display($valueObject->getResultsScore())}
                </span>
            </td>
            {if $interfaceObject->showRemarks()}
            <td class="bottom_line">
                <span class="{$interfaceObject->diff($compareValueObject->getResultsScoreComment(),$valueObject->getResultsScoreComment())}">
                    <span class="comment">{$valueObject->getResultsScoreComment()|nl2br}</span>
                </span>
            </td>
            {/if}
        </tr>
        {/if}
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
<!-- /employeeFinalResultHistory.tpl -->