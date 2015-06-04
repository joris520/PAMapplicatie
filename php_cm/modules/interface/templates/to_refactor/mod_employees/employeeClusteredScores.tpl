<!-- employeeClusteredScores.tpl -->
<table border="0" cellspacing="0" cellpadding="2" width="100%">
    <tr style="background-color: #ddd;" >
        <th colspan="100%" class="cluster-title">{$clusterName}</th>
        <th class="cluster-title action-buttons" width="100px" id="{$clusterButtonsId}">{$clusterActionButtons}</th>
    </tr>
    <tr>
        <th             class="content-title" style="padding-left: 10px;">{'COMPETENCE'|TXT_UCF}</th>
        <th width="15%" class="content-title centered">{'CUSTOMER_MGR_SCORE_LABEL'|constant|TXT_UCF}</th>
        {if 'CUSTOMER_OPTION_SHOW_360'|constant}
        <th width="5%"  class="content-title centered">{'CUSTOMER_360_SCORE_LABEL'|constant|TXT_UCF}</th>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_NORM'|constant}
        <th width="5%"  class="content-title centered">{'NORM'|TXT_UCF}</th>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_WEIGHT'|constant}
        <th width="5%"  class="content-title centered">{'WEIGHT_FACTOR'|TXT_UCF}</th>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_ACTIONS'|constant && PERMISSION_EMPLOYEE_PDP_ACTIONS|constant > 0}{* TODO logica naar interface *}
        <th width="5%"  class="content-title centered">{'ACTIONS'|TXT_UCF}</th>
        {/if}
        {if 'CUSTOMER_OPTION_USE_SKILL_NOTES'|constant}
        <th width="20%"  class="content-title">{'CUSTOMER_MANAGER_REMARKS_LABEL'|constant|TXT_UCF}</th>
        <th width="40" class="content-title">&nbsp;</th>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_360'|constant && 'CUSTOMER_OPTION_SHOW_360_REMARKS'|constant}
        <th width="20%"  class="content-title">{'EMPLOYEE_REMARKS'|TXT_UCF}</th>
        {/if}
    </tr>
    {foreach $clusterScores as $clusterScore}

    <tr id="competence_row_{$clusterScore.competence_id}" class="{if $clusterScore.is_cluster_main == 1} main_competence{/if}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="content-line{if $clusterScore.cluster_has_main}{if $clusterScore.is_cluster_main == 1} main_competence{else} sub_competence{/if}{/if}">
            <span width="40px">{$clusterScore.key_display}</span>
            <span id="click{$clusterScore.competence_id}">{$clusterScore.competence_link}</span>{$clusterScore.additional_display}
            <span class="activeRow icon-style"><img src="{'ICON_INFO'|constant}" title="KLIK VOOR DETAILS"></span>
        </td>
        <td class="content-line centered">{$clusterScore.boss_score_display}</td>
        {if 'CUSTOMER_OPTION_SHOW_360'|constant}
        <td class="content-line centered{$clusterScore.diffIndicator}">{$clusterScore.employee_score_display}</td>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_NORM'|constant}
        <td class="content-line centered">{$clusterScore.norm_display}</td>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_WEIGHT'|constant}
        <td class="content-line centered">{$clusterScore.weight_factor}</td>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_ACTIONS'|constant && PERMISSION_EMPLOYEE_PDP_ACTIONS|constant > 0}
        <td class="content-line centered">{$clusterScore.actions}</td>
        {/if}
        {if 'CUSTOMER_OPTION_USE_SKILL_NOTES'|constant}
        <td id="{$clusterScore.boss_note_html_id}" class="content-line">{$clusterScore.boss_note}</td>
        <td id="{$clusterScore.boss_note_buttons_html_id}" class="content-line">{$clusterScore.boss_note_buttons}</td>
        {/if}
        {if 'CUSTOMER_OPTION_SHOW_360'|constant && 'CUSTOMER_OPTION_SHOW_360_REMARKS'|constant}
        <td class="content-line">{$clusterScore.employee_note|nl2br}&nbsp;</td>
        {/if}
    </tr>
    <tr id="detail_row_{$clusterScore.competence_id}" class="hidden-info">
        <td colspan="100%" id="detail_content_{$clusterScore.competence_id}" style="padding-left: 10px;"></td>
    </tr>
    {/foreach}
    <tr>
        <td colspan="100%"><br><div id="logs" align="right">{$lastModifiedLog}</div></td>
    </tr>
</table>
<!-- /employeeClusteredScores.tpl -->