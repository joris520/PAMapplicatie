<!-- cluster_competences.tpl -->
<h1>{$categoryName}</h1>
<table border="0" cellpadding="1" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="cluster-title" colspan="2">{'CLUSTER'|TXT_UCW} : &nbsp;<strong>{$clusterName}</strong></th>
            <th class="cluster-title action-buttons" width="100px">{$clusterActionButtons}</th>
        </tr>
        {if $clusterCompetences|count > 0}
        <tr>
            <th class="content-title" style="padding-left: 10px;">{'COMPETENCE'|TXT_UCF}</th>
            <th class="content-title centered">{'SCALE'|TXT_UCF}</th>
            <th class="content-title action-buttons">&nbsp;</th>
        </tr>
        {/if}
    </thead>
    <tbody>
    {if $clusterCompetences|count > 0}
        {foreach $clusterCompetences as $competence}
        {if $competence.hilite}
            {assign var='new_row_indicator' value='class="short_hilite" style="display:none"'}
        {else}
            {assign var='new_row_indicator' value=''}
        {/if}
        <tr {$new_row_indicator} id="{$competence.competence_id}" class="content-line{if $competence.is_cluster_main == 1} main_competence{/if}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
            <td class="content-line{if $competence.cluster_has_main}{if $competence.is_cluster_main == 1} main_competence{else} sub_competence{/if}{/if}" id="com1{$competence.competence_id}" {$competence.cluster_main_style}>
                <span width="40px">{$competence.key_display}</span>
                <span id="click{$competence.competence_id}">{$competence.competence_link}</span>
                <span class="activeRow"><img src="{'ICON_INFO'|constant}" title="click on competence for details"></span>
            </td>
            <td class="content-line centered" id="com2{$competence.competence_id}">
                {$competence.scale}
            </td>
            <td class="content-line action-buttons activeRow" id="com3{$competence.competence_id}">
                {$competence.competence_actions}
            </td>
        </tr>
        <tr id="detail_row_{$competence.competence_id}" class="hidden-info">
            <td colspan="3" id="detail_content_{$competence.competence_id}" style="padding-left: 10px;"></td>
        </tr>
        {/foreach}
    {else}
        <tr>
            <td colspan="100%">{'NO_COMPETENCE_RETURN'|TXT_UCF}</td>
        </tr>
    {/if}
    </tbody>
</table>
{if $hasCollectiveKeyCompetences}
<br />{'NOTE'|TXT_UCF}: {'SIGN_IS_KEY_COMP'|constant}= {'COLLECTIVE_KEY_COMPETENCE'|TXT_UCF}
{/if}
<div id="logs" align="right">{$lastModifiedLogs}</div>
<!-- /cluster_competences.tpl -->