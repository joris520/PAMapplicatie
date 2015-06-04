{* smarty *}
<!-- threeSixtyInvitationFormCompetences.tpl -->
{if $id_f <> ''}
    <table border="0" cellspacing="0">
        <tr><td>
{*
            <select name="selected_competences" id="selected_competences" size="10" class="select_width_150" multiple="multiple" onMouseDown="GetCurrentListValues(this);" onchange="FillListValues(this);">
*}
            <select name="selected_competences" id="selected_competences" size="10" class="select_width_150" multiple="multiple">
                {foreach $competences as $competence}
{*
                <option value="{$competence.id}" selected="selected">{{$competence.category}|upper|replace:' ':'_'|TXT_UCF} / {$competence.cluster} / {$competence.competence}</option>
*}
                <option value="{$competence.id}">{{$competence.category}|upper|replace:' ':'_'|TXT_UCF} / {$competence.cluster} / {$competence.competence}</option>
                {foreachelse}
                <option value="">{'NO_COMPETENCE_RETURN'|TXT_UCF}</option>
                {/foreach}
            </select>
            <br />
            <span style="font-size:smaller;">{'CTRL_CLICK_FOR_MULTI_SELECT'|TXT_UCF}</span>
        </td><td>
            <input type="button" id="selectAll_{$competences.name}"   class="btn btn_width_110" onclick="SelectAllList('selected_competences');"   value="{'SELECT_ALL'|TXT_UCW}"  ><br />
            <input type="button" id="deselectAll_{$competences.name}" class="btn btn_width_110" onclick="DeselectAllList('selected_competences');" value="{'DESELECT_ALL'|TXT_UCW}">
        </td></tr>
    </table>
{else}
    {'PLEASE_SELECT_A_JOB_PROFILE'|TXT_UCF}
{/if}
<!-- /threeSixtyInvitationFormCompetences.tpl -->