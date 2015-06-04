<!-- employeeScores.tpl -->
<table border="0" cellspacing="0" cellpadding="2" width="650">
    <tr>
        <td width="200" class="content-label">{'BASED_ON_JOB_PROFILE'|TXT_UCF} :</td>
        <td class="content-value">{$functionsInfo}</td>
    </tr>
    <tr>
        <td class="content-label">{'LATEST_SAVED'|TXT_UCF} timeshot :</td>
        <td class="content-value" id="{$historyStateHtmlId}">{$historyState}</td>
    </tr>
    <tr id="row_{$conversationDateHtmlId}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="content-label">{'CONVERSATION_DATE'|TXT_UCF} :</td>
        <td class="content-value" id="{$conversationDateHtmlId}">{$conversationDateHtml}</td>
    </tr>
</table>

{$employeeScoresHtml}
{if $hasKeyCompetences}
{'NOTE'|TXT_UCF} : {'SIGN_IS_KEY_COMP'|constant}= {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}<br>
{/if}
{if $hasAdditionalFunctions}
{'NOTE'|TXT_UCF} : {'SIGN_COMP_ADDITIONAL_PROFILE'|constant}= {'ADDITIONAL_JOB_PROFILES'|TXT_UCF}<br>
{/if}
<br />
<table border="0" cellspacing="0" cellpadding="2" width="830">
    {foreach $employeeScoresQuestions as $scoreQuestion}
    <tr id="question_row_{$scoreQuestion.question_id}"  onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td width="250" class="content-label"><strong>{$scoreQuestion.question_html} : </strong></td>
        <td class="content-value" id="{$scoreQuestion.answer_html_id}">{$scoreQuestion.answer_html}</td>
        <td width="40" class="content-title" id="{$scoreQuestion.answer_buttons_html_id}">{$scoreQuestion.answer_buttons_html}</td>
    </tr>
    {/foreach}
</table>
<!-- /employeeScores.tpl -->