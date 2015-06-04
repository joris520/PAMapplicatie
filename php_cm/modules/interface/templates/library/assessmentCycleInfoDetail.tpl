<!-- assessmentCycleInfoDetail.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=previousValueObject value=$interfaceObject->getPreviousValueObject()}
{* todo: style naar css *}
<table  border="0" cellspacing="0" cellpadding="2">
    <tr id="current_assessment_detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this, 'no-hilite');" onmouseout="deactivateThisRow(this, 'no-hilite');">
        <td nowrap class="" style="padding: 5px;">
            {if $interfaceObject->showCyclePrefix()}
                {if $interfaceObject->showPreviousCycle()}
                {'CURRENT_ASSESSMENT_CYCLE'|TXT_UCF}
                {else}
                {'ASSESSMENT_CYCLE'|TXT_UCF}
                {/if}
            {/if}
            {$valueObject->getAssessmentCycleName()}
            <span class="activeRow icon-style">
                &nbsp;{$interfaceObject->getCurrentHoverIcon()}
            </span>
            <span class="activeRow hiddenActiveRow">
                &nbsp;{$interfaceObject->getCurrentTitle()}
            </span>
        </td>
    </tr>
    {if $interfaceObject->showPreviousCycle()}
    <tr id="prev_assessment_detail_row_{$previousValueObject->getId()}" onmouseover="activateThisRow(this, 'no-hilite');" onmouseout="deactivateThisRow(this, 'no-hilite');">
        <td nowrap class="" style="padding: 5px;">
            {'PREVIOUS_ASSESSMENT_CYCLE'|TXT_UCF}
            {$previousValueObject->getAssessmentCycleName()}
            <span class="activeRow icon-style">
                &nbsp;{$interfaceObject->getPreviousHoverIcon()}
            </span>
            <span class="activeRow hiddenActiveRow">
                &nbsp;{$interfaceObject->getPreviousTitle()}
            </span>
        </td>
    </tr>
    {/if}
</table>
<!-- /assessmentCycleInfoDetail.tpl -->