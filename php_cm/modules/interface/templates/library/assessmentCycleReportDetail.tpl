<!-- assessmentCycleReportDetail.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{* todo: style naar css *}
<table border="0" cellspacing="0" cellpadding="2">
    <tr id="current_assessment_report_row_{$valueObject->getId()}" onmouseover="activateThisRow(this, 'no-hilite');" onmouseout="deactivateThisRow(this, 'no-hilite');">
        <td nowrap class="{$interfaceObject->getPrefixClass()}" style="padding: 5px;">
            {if $interfaceObject->showCyclePrefix()}
                {'REPORT'|TXT_UCF} {'ASSESSMENT_CYCLE'|TXT_LC}
            {/if}
            {$valueObject->getAssessmentCycleName()}:
            &nbsp;{$interfaceObject->getCurrentTitle()}
        </td>
    </tr>
</table>
<!-- /assessmentCycleReportDetail.tpl -->