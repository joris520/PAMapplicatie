<!-- questionDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="bottom_line form-label" style="width:100px;">{'ORDER'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->getSortOrder()}</td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'ASSESSMENT_QUESTION'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->getQuestion()|nl2br}</td>
    </tr>
</table>

<!-- /questionDelete.tpl -->