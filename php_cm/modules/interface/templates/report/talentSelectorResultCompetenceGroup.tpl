<!-- talentSelectorResultCompetenceGroup.tpl -->
{assign var=valueObject         value=$interfaceObject->getValueObject()}
    <tr>
        <th class="bottom_line" colspan="100%" style="background-color:#fff;">
            <h2>{$valueObject->getCompetenceName()}
                {OperatorConverter::display($valueObject->getOperator())}
                {ScoreConverter::display($valueObject->getScore())} - {ScoreConverter::description($valueObject->getScore())}
            </h2>
        </th>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $talentSelectorView}
        {$talentSelectorView->fetchHtml()}
    {/foreach}
<!-- /talentSelectorResultCompetenceGroup.tpl -->