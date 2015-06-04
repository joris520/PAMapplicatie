<!-- employeeCompetencePrintOptionDetail.tpl -->
{if !$interfaceObject->isInitialVisible()}
{assign var=initialHiddenClass value='hidden-info'}
{/if}
{if $interfaceObject->isAllowedShowRemarks()}
    <tr class="print_option_detail_{$interfaceObject->getPrintOption()} {$initialHiddenClass}">
        <td style="padding-left:{$interfaceObject->getDetailIndentation()};">
            <input id="show_remarks_{$interfaceObject->getPrintOption()}" name="show_remarks_{$interfaceObject->getPrintOption()}" value="1" type="checkbox" {if $interfaceObject->isChecked()}checked{/if}>
            <label for="show_remarks">{'PRINT_OPTION_REMARKS'|TXT_UCF}
        </td>
    </tr>
{/if}
{if $interfaceObject->isAllowedShow360()}
    <tr class="print_option_detail_{$interfaceObject->getPrintOption()} {$initialHiddenClass}">
        <td style="padding-left:{$interfaceObject->getDetailIndentation()};">
            <input id="show_threesixty_{$interfaceObject->getPrintOption()}" name="show_threesixty_{$interfaceObject->getPrintOption()}" value="1" type="checkbox" {if $interfaceObject->isChecked()}checked{/if}>
            <label for="show_threesixty">{'PRINT_OPTION_EMPLOYEE_SCORES'|TXT_UCF}
        </td>
    </tr>
{/if}
{if $interfaceObject->isAllowedShowPdpAction()}
    <tr class="print_option_detail_{$interfaceObject->getPrintOption()} {$initialHiddenClass}">
        <td style="padding-left:{$interfaceObject->getDetailIndentation()};">
            <input id="show_action_{$interfaceObject->getPrintOption()}" name="show_action_{$interfaceObject->getPrintOption()}" value="1" type="checkbox" {if $interfaceObject->isChecked()}checked{/if}>
            <label for="show_action">{'PRINT_OPTION_ACTION_FORM_MEETING'|TXT_UCF}{* TODO: PRINT_ACTION_FORM_MEETING *}
        </td>
    </tr>
{/if}
<!-- /employeeCompetencePrintOptionDetail.tpl -->