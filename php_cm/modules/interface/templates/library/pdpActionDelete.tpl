<!-- pdpActionDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="bottom_line form-label" style="width:100px;">{'PDP_ACTION'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->getActionName()}</td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'PROVIDER'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->getProvider()}</td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'DURATION'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->getDuration()}</td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'COST'|TXT_UCF}</td>
        <td class="bottom_line form-value">{PdpCostConverter::display($valueObject->getCost())}</td>
    </tr>
</table>
<!-- /pdpActionDelete.tpl -->