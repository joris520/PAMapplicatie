<!-- talentSelectorResultView.tpl -->
{assign var=valueObject  value=$interfaceObject->getValueObject()}
{assign var=score        value=$valueObject->getScore()}
{assign var=employeeName value=$valueObject->getEmployeeName()}
    <tr>
        <td class="bottom_line">{$employeeName}</td>
        <td class="bottom_line">{ScoreConverter::display($score)} - {ScoreConverter::description($score)}</td>
    </tr>
<!-- /talentSelectorResultView.tpl -->