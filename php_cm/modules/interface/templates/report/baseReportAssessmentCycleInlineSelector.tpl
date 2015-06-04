<!-- baseReportAssessmentCycleInlineSelector.tpl -->
<table border="0" cellspacing="0" cellpadding="1" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-value">
            {'SELECT_ASSESSMENT_CYCLE'|TXT_UCF}&nbsp;
            <select id="assessment_cycle" name="assessment_cycle"
                    onchange="if (this.selectedIndex != 0) submitInlineSafeForm('{$interfaceObject->getSafeFormIdentifier()}', '{$interfaceObject->getFormId()}')">
            {include    file         = 'components/selectIdValuesComponent.tpl'
                        idValues     = $interfaceObject->getIdValues()
                        currentValue = $interfaceObject->getCurrentId()
                        subject      = TXT_LC('REPORT_PERIOD')
                        required     = false}
            </select>
            {$interfaceObject->getCancelLink()}
        </td>
    </tr>
</table>
<!-- /baseReportAssessmentCycleInlineSelector.tpl -->