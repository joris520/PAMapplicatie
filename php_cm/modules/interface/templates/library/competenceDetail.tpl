<!-- competenceDetail.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="details-frame" style="background-color:#ddd;">
    <tr>
        <td class="details-line-label">{'CATEGORY'|TXT_UCF} :</td>
        <td colspan="4" class="details-line-value">{CategoryConverter::display($valueObject->categoryName)}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'CLUSTER'|TXT_UCF} :</td>
        <td colspan="4" class="details-line-value">{$valueObject->clusterName}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'DESCRIPTION'|TXT_UCF} : </td>
        <td colspan="4" class="details-line-value">{$valueObject->competenceDescription|nl2br}</td>
    </tr>
    {if $interfaceObject->hasNumericScale}
    <tr>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_1)}] {NormConverter::description(NormValue::NORM_1)}</td>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_2)}] {NormConverter::description(NormValue::NORM_2)}</td>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_3)}] {NormConverter::description(NormValue::NORM_3)}</td>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_4)}] {NormConverter::description(NormValue::NORM_4)}</td>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_5)}] {NormConverter::description(NormValue::NORM_5)}</td>
    </tr>
    <tr>
        <td class="details-line">{$valueObject->score1Description|nl2br}</td>
        <td class="details-line">{$valueObject->score2Description|nl2br}</td>
        <td class="details-line">{$valueObject->score3Description|nl2br}</td>
        <td class="details-line">{$valueObject->score4Description|nl2br}</td>
        <td class="details-line">{$valueObject->score5Description|nl2br}</td>
    </tr>
    {/if}
    {if $interfaceObject->hasYNScale}
    <tr>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_Y, 1)}] {NormConverter::description(NormValue::NORM_Y)}</td>
        <td class="details-line-label" width="20%">[{NormConverter::display(NormValue::NORM_N, 1)}] {NormConverter::description(NormValue::NORM_N)}</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
    </tr>
    {/if}
</table>
<!-- /competenceDetail.tpl -->