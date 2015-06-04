<!-- employeeCompetenceScoreEdit.tpl -->
{assign var=competenceValueObject   value=$interfaceObject->getCompetenceValueObject()}
{assign var=valueObject             value=$interfaceObject->getValueObject()}
{assign var=competenceId            value=$competenceValueObject->competenceId}
{assign var=keepAliveCallback       value=$interfaceObject->getKeepAliveCallback()}
<tr id="edit_competence_row_{$competenceId}" class="{if $competenceValueObject->competenceIsMain} main_competence{/if}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td id="edit_{$interfaceObject->getDetailLinkId()}"
        class="form-label clickable
                {if $interfaceObject->hasClusterMainCompetence()}
                    {if $competenceValueObject->competenceIsMain} main_competence{else} sub_competence{/if}
                {/if}"
        style="width:{$interfaceObject->getCompetenceWidth()};"
        onClick="{$interfaceObject->getDetailOnClick()};return false;">
        <span width="40px">{$interfaceObject->getIsKeySymbol()}</span>
        <span>
            {$competenceValueObject->getCompetenceName()}
        </span>{$interfaceObject->getSymbolIsAdditionalCompetence()}
        <span class="activeRow icon-style"><img src="{'ICON_INFO'|constant}" title="{'SHOW_DETAILS'|TXT_UCF}"></span>
    </td>
    <td class="form-value" style="width:{$interfaceObject->getScoreWidth()};">
        {include file='components/scoreEditComponent.tpl'
                 scaleType=$competenceValueObject->getCompetenceScaleType()
                 inputName=$interfaceObject->getScoreInputName()
                 isEmptyAllowed=$competenceValueObject->getCompetenceIsOptional()
                 keepAliveCallback=$keepAliveCallback
                 score=$valueObject->getScore()}
        {if $interfaceObject->showNorm()}
        <span class="display_norm" style="font-style:italic;">&nbsp;&nbsp;&nbsp;{'NORM'|TXT_LC}: {NormConverter::input($competenceValueObject->competenceFunctionNorm)}</span>
        {/if}
    </td>
    <td class="form-value actions" style="width:{$interfaceObject->getActionsWidth()};">
        {if $interfaceObject->showRemarks()}
        {$interfaceObject->getToggleNoteVisibilityLink()}
        {/if}
    </td>
</tr>
<tr id="edit_detail_row_{$competenceId}" class="hidden-info">
    <td colspan="100%" id="edit_detail_content_{$competenceId}" style="padding-left: 10px;"></td>
</tr>
{if $interfaceObject->showRemarks()}
{if !empty($keepAliveCallback)}
{assign var=onFocusFunction value='onFocus="'|cat:$keepAliveCallback|cat:';return false;"'}
{assign var=onBlurFunction value='onBlur="'|cat:$keepAliveCallback|cat:';return false;"'}
{/if}
<tr id="{$interfaceObject->getToggleNoteId($competenceValueObject->getCompetenceId())}" class="comment-row" {if !$interfaceObject->isInitialVisibleNotes()}style="display:none;"{/if}>
    <td class="form_value" colspan="100%" style="padding-left:69px;">
        <textarea id="{$interfaceObject->getNoteInputName()}"  name="{$interfaceObject->getNoteInputName()}"  style="height:100px; width:690px" {$onFocusFunction} {$onBlurFunction}>{$valueObject->getNote()}</textarea>
    </td>
</tr>
{/if}
<tr>
    <td colspan="100%" >&nbsp;</td>
</tr>
<!-- /employeeCompetenceScoreEdit.tpl -->