<!-- talentSelectorView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr>
    <td class="bottom_line">
        <input type="checkbox" name="competence_name_{$valueObject->getCompetenceId()}" value="{$valueObject->getCompetenceName()}"/>
    </td>
    <td class="bottom_line">
        {$valueObject->getCompetenceName()}
    </td>
    <td class="bottom_line">
        {ScaleConverter::display($valueObject->getCompetenceScaleType())}
    </td>
    <td class="bottom_line">
        <select name="operator_{$valueObject->getCompetenceId()}" style="width:40px">
            {include    file         = 'components/selectOptionsComponent.tpl'
                        values       = OperatorValue::values($valueObject->competenceScaleType)
                        required     = TRUE
                        converter    = 'OperatorConverter'}
        </select>
    </td>
    <td class="bottom_line">
        <select name="score_{$valueObject->getCompetenceId()}" style="width:90px">
        {include file='components/scoreSelectComponent.tpl'
                 scaleType=$valueObject->competenceScaleType}
        </select>
    </td>
</tr>
<!-- /talentSelectorView.tpl -->