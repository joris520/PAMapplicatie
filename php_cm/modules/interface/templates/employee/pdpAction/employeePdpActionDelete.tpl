<!-- employeePdpActionDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            {'PDP_ACTION'|TXT_UCF}
        </td>
        <td class="form-value">
            {PdpActionNameConverter::display($valueObject->getActionName(), PdpActionNameConverter::EMPTY_LABEL, $valueObject->isUserDefined())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'STATUS'|TXT_UCF}
        </td>
        <td class="form-value">
            {PdpActionCompletedConverter::image($valueObject->getIsCompletedStatus())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'DEADLINE_DATE'|TXT_UCF}
        </td>
        <td class="form-value">
            {DateConverter::display($valueObject->getTodoBeforeDate())}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            {'ACTION_OWNER'|TXT_UCF}
        </td>
        <td class="form-value">
            {$valueObject->getOwnerName()}
        </td>
    </tr>
</table>
<!-- /employeePdpActionDelete.tpl -->