<!-- pdpActionCompetencesSelector.tpl -->
    <tr>
        <th class="cluster-title" colspan="3">{$clusterName}</th>
    </tr>
    <tr>
        <th class="content-title sub-level">{'COMPETENCE'|TXT_UCF}</th>
        <th class="content-title centered"  width="100px">{'SCORE'|TXT_UCF}</th>
        <th class="content-title">&nbsp;</th>
    </tr>
    {foreach $pdpActionCompetences as $pdpActionCompetence}
    <tr>
        <td class="content-line sub-level" >{$pdpActionCompetence.competenceSelector}</td>
        <td class="content-line centered">{$pdpActionCompetence.competenceScore}</td>
        <th class="content-title">&nbsp;</th>
    </tr>
    {/foreach}
<!-- /pdpActionCompetencesSelector.tpl -->