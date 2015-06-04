<!-- employeeCompetenceScoreView.tpl -->
{*interfaceObject*}
{*noteCols*}
    {assign var=competenceValueObject               value=$interfaceObject->getEmployeeCompetenceValueObject()}
    {assign var=scoreValueObject                    value=$interfaceObject->getCurrentScoreValueObject()}
    {assign var=previousScoreValueObject            value=$interfaceObject->getPreviousScoreValueObject()}
    {assign var=employeeScoreValueObject            value=$interfaceObject->getCurrentSelfAssessmentScoreValueObject()}
    {assign var=previousEmployeeScoreValueObject    value=$interfaceObject->getPreviousSelfAssessmentScoreValueObject()}

    {assign var=currentAssessmentCycle              value=$scoreValueObject->getAssessmentCycleValueObject()}
    {assign var=previousAssessmentCycle             value=$previousScoreValueObject->getAssessmentCycleValueObject()}
    <tr id="competence_row_{$competenceValueObject->getCompetenceId()}"
        class="{if $competenceValueObject->competenceIsMain} main_competence{/if}"
        onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td id="{$interfaceObject->getDetailLinkId()}" class="clickable content-line{if $interfaceObject->hasClusterMainCompetence()}{if $competenceValueObject->competenceIsMain} main_competence{else} sub_competence{/if}{/if}" onClick="{$interfaceObject->getDetailOnClick()};return false;">
            <span class="activeRow icon-style" onClick="{$interfaceObject->getDetailOnClick()};return false;">
                <img src="{'ICON_INFO'|constant}" title="{'SHOW_DETAILS'|TXT_UCF}">
            </span>
            <span width="40px">{$interfaceObject->getIsKeySymbol()}</span>
            <span>{$competenceValueObject->competenceName}</span>{$interfaceObject->getSymbolIsAdditionalCompetence()}
        </td>
        <td class=" content-line centered">
            {assign var=managerPreviousScore value=$previousScoreValueObject->getScore()}
            {ScoreConverter::employeeScoreText($managerPreviousScore, $interfaceObject->isAllowedViewPreviousScore())}
        </td>
        {if $interfaceObject->show360()}
        {assign var=previousEmployeeScore value=$previousEmployeeScoreValueObject->getScore()}
        {if $interfaceObject->isAllowedViewPreviousEmployeeScore()}
        <td class="content-line centered{$interfaceObject->getPreviousDiffIndicator()}" title="{ScoreConverter::tooltipTitle($previousEmployeeScore, $interfaceObject->previousIsInvited())}">
            {ScoreConverter::display($previousEmployeeScore)}
        </td>
        {else}
        <td class="content-line centered" title="{if $interfaceObject->previousIsInvited()}{TXT_UCF('SCORE_STATUS_INFO_TEXT')}{/if}">{if $interfaceObject->previousIsInvited()}{ScoreConverter::employeeScoreText($previousEmployeeScore, false)}{else}-{/if}</td>
        {/if}
        {/if}
        <td class="content-line centered{if $interfaceObject->hasClusterMainCompetence()}{if $competenceValueObject->competenceIsMain} main_competence{else} current-period{/if}{else} current-period{/if}"
            style="{if $interfaceObject->hasClusterMainCompetence()}{if $competenceValueObject->competenceIsMain} background-color:#eee{else}{/if}{/if}">
            {assign var=managerScore value=$scoreValueObject->getScore()}
            {ScoreConverter::employeeScoreText($managerScore, $interfaceObject->isAllowedViewCurrentScore())}
        </td>
        {if $interfaceObject->show360()}
        {assign var=currentEmployeeScore value=$employeeScoreValueObject->score}
        {if $interfaceObject->isAllowedViewCurrentEmployeeScore()}
        <td class="content-line centered{$interfaceObject->getCurrentDiffIndicator()} current-period" title="{ScoreConverter::tooltipTitle($currentEmployeeScore, $interfaceObject->currentIsInvited())}">
            {ScoreConverter::display($currentEmployeeScore)}
        </td>
        {else}
        <td class="content-line centered current-period" title="{if $interfaceObject->currentIsInvited()}{TXT_UCF('SCORE_STATUS_INFO_TEXT')}{/if}">{if $interfaceObject->currentIsInvited()}{ScoreConverter::employeeScoreText($currentEmployeeScore, false)}{else}-{/if}</td>
        {/if}
        {/if}
        {if $interfaceObject->showNorm()}
        <td class="content-line centered">{NormConverter::display($competenceValueObject->competenceFunctionNorm)}</td>
        {/if}
        {if $interfaceObject->showWeight()}
        <td class="content-line centered">{$competenceValueObject->competenceFunctionWeight}</td>
        {/if}
        {if $interfaceObject->showPdpActions()}
        <td class="content-line centered">{$competenceValueObject->pdpActionCount}</td>
        {/if}
        <td class="content-line " style="text-align:right">
            {if $interfaceObject->showAnyRemarks() && $interfaceObject->hasNotes()}
                {$interfaceObject->getToggleNoteVisibilityLink()}
            {/if}
                {$interfaceObject->getHistoryLink()}
        </td>
    </tr>
    <tr id="detail_row_{$competenceValueObject->competenceId}" class="hidden-info">
        <td colspan="100%" id="detail_content_{$competenceValueObject->competenceId}" style="padding-left: 10px;"></td>
    </tr>
    {if $interfaceObject->showAnyRemarks() ||
        $interfaceObject->isAllowedViewCurrentScore() || $interfaceObject->isAllowedViewPreviousScore()}
        {if $interfaceObject->hasNotes()}
            {assign var=commentIndentation value='margin-left:40px'}
            {assign var=didShowRemarks value=false}
            <tr id="{$interfaceObject->getToggleNoteId($competenceValueObject->getCompetenceId())}" class="comment-row" {if !$interfaceObject->isInitialVisibleNotes()} style="display:none;"{/if}>
                <td class="content-line" colspan="100%">
                    {if $interfaceObject->showBossRemarks() && $interfaceObject->isAllowedViewCurrentScore() && $scoreValueObject->hasNote()}
                    {assign var=didShowRemarks value=true}
                    <div class="remarks-content " style="{$commentIndentation}; padding:10px;">
                        <strong>{$currentAssessmentCycle->getAssessmentCycleName()} {'CUSTOMER_MANAGER_REMARKS_LABEL'|constant|TXT_LC}</strong><br />
                        <span class="comment">{$scoreValueObject->getNote()|nl2br}<span>
                    </div>
                    {/if}
                    {if $interfaceObject->show360Remarks() && $interfaceObject->isAllowedViewCurrentEmployeeScore() && $employeeScoreValueObject->hasNote()}
                    <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                        <strong>{$currentAssessmentCycle->getAssessmentCycleName()}  {'EMPLOYEE_REMARKS'|TXT_LC}</strong><br />
                        <span class="comment">{$employeeScoreValueObject->getNote()|nl2br}</span>
                    </div>
                    {/if}
                    {if $interfaceObject->showBossRemarks() && $interfaceObject->isAllowedViewPreviousScore() && $previousScoreValueObject->hasNote()}
                    {assign var=didShowRemarks value=true}
                    <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                        <strong>{$previousAssessmentCycle->getAssessmentCycleName()} {'CUSTOMER_MANAGER_REMARKS_LABEL'|constant|TXT_LC}</strong><br />
                        <span class="comment">{$previousScoreValueObject->getNote()|nl2br}</span>
                    </div>
                    {/if}
                    {if $interfaceObject->show360Remarks() && $interfaceObject->isAllowedViewPreviousEmployeeScore() && $previousEmployeeScoreValueObject->hasNote()}
                    {assign var=didShowRemarks value=true}
                    <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                        <strong>{$previousAssessmentCycle->getAssessmentCycleName()} {'EMPLOYEE_REMARKS'|TXT_LC}</strong><br />
                        <span class="comment">{$previousEmployeeScoreValueObject->getNote()|nl2br}</span>
                    </div>
                    {/if}
                </td>
            </tr>
            {if $didShowRemarks}
            <tr>
                <td id="spacer_comment_row_{$competenceValueObject->getCompetenceId()}" class="comment-row" style="display:none;" colspan="100%">&nbsp;</td>
            </tr>
            {/if}
        {/if}
    {/if}
<!-- /employeeCompetenceScoreView.tpl -->