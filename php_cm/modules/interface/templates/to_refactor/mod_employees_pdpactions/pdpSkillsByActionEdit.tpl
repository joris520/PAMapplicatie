{* te vullen vars:
    - scoredSkills array met scored skill info
        $scored_skill[cluster_id];
        $scored_skill[cluster_name];
        $scored_skill[skill_id];
        $scored_skill[skill_name];
        $scored_skill[employee_point_id];
        $scored_skill[connected_action_id];
    - prevSkills comma-seperated string met de huidig selected skills
    - newAction boolean (empty($id_pdpea))
*}
<!-- pdpSkillsByActionEdit.tpl -->
{function name=writeCheckbox input_id='' is_selected=false}
    <input type="checkbox"
           name="{$input_id}"
           id="{$input_id}"
           {if $is_selected} checked="checked" {/if}>
{/function}

{function name=writeLabel  label_name='' input_id='' is_selected=false}
    <label for="{$input_id}"
           {if $is_selected} style="font-weight: bold" {/if}
           >
        {$label_name}
    </label>
{/function}

{function name=writeSkillsList action_skills=''}
    {include file='to_refactor/mod_employees_pdpactions/pdpSkillsByActionView.tpl'
             actionSkills=$action_skills}
{/function}


{* de hooffunctie van deze template *}
{assign var=elementCount value=$scoredSkills|count}{* hoeveel elementen *}
{if $elementCount > 0}
    {assign var=generatedInfoCode value=$prevSkills}
    {*if $isNewAction}
        <div id="show_edit_comp" style="display:block"><!-- visibility: nieuwe actie -->
    {else*}
        <div id="show_info_comp">

            <br/>
                <table>
                    <tr>
                        <td style="width:100px;">
                            {'COMPETENCES'|TXT_UCF}:
                        </td>
                        <td>
                            {if $actionSkills|@count > 0}
                            <strong>{writeSkillsList action_skills=$actionSkills}</strong>
                                {*genereer gerelateerde skill lijst{$generatedInfoCode}*}
                            {else}
                                {'NO_RELATED_COMPETENCES'|TXT_UCF}
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:100px;">
                            &nbsp;
                        </td>
                        <td id="{$competencesToggleId}">
                            {$competencesToggleLink}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:100px;">
                            &nbsp;
                        </td>
                        <td>
                            <div id="{$competencesToggleContentId}" style="display:none;"><!-- visibility: edit actie -->
                        {*/if*}
                                <strong>{'RELATE_TO_COMPTENCES'|TXT_UCF}:</strong>
                                <div style=" background-color:white;width:680px;height:200px; overflow:auto;"><!-- skills_data -->
                                    <table style="padding: 4px;width:650px;">
                                    <!--tbody-->
                                    {assign var=last_cluster  value=''}
                                    {assign var=last_knowledge_skill  value=''}
                                    {* assign var=last_skill_id value='' *}
                                    {assign var=available_skill_fields value=''}
                                    {assign var=isFirst value=true}
                                    {foreach $scoredSkills as $scoredSkill}
                                        {* de input id voor dit veld voor latere verwerking *}
                                        {assign var=skill_input_id value=$scoredSkill.employee_point_input_id}
                                        {* bijhouden welke id's er allemaal zijn *}
                                        {assign var=available_skill_fields value=$available_skill_fields|cat:$scoredSkill.skill_id|cat:','}
                                        {if $last_knowledge_skill!= $scoredSkill.knowledge_skill}
                                        {if !$isFirst}<tr><td colspan="3"></td></tr>{/if}

                                        <tr>
                                            <td colspan="3" style="padding-left: 5px; padding-top:5px;">
                                                <strong>{$scoredSkill.knowledge_skill}</strong>
                                            </td>
                                        </tr>
                                        {/if}
                                        {if $last_cluster != $scoredSkill.cluster_name}
                                        <tr>
                                            <td class="shaded_title" colspan="3" style="padding-left: 5px;">
                                                {$scoredSkill.cluster_name}
                                            </td>
                                        </tr>
                                        {/if}{* last_cluster *}
                                        <tr>
                                            <td style="padding-left: 20px; width: 25px;">
                                                {writeCheckbox input_id=$skill_input_id
                                                            is_selected=$scoredSkill.isConnected}
                                            </td>
                                            <td>
                                                {writeLabel label_name=$scoredSkill.skill_name
                                                            input_id=$skill_input_id
                                                            is_selected=$scoredSkill.isConnected}
                                            </td>
                                            <td>
                                                {*if $scoredSkill.employee_score != null}
                                                    {assign var=prefix_label value='SCORE'|TXT_UCF}
                                                    {assign var=score_label value=' ('|cat:$prefix_label|cat:': '|cat:$module_utils_object->ScorepointText($scoredSkill.employee_score)|cat:')'}
                                                {else}
                                                    {assign var=score_label value=''}
                                                {/if}
                                                {$score_label*}
                                            </td>
                                        </tr>
                                        {*if $last_cluster != $scoredSkill.cluster_name}
                                        <tr>
                                            <td colspan="3">{$last_cluster}:{$scoredSkill.cluster_name}&nbsp;</td>
                                        </tr>
                                        {/if}{* last_cluster *}
                                        {assign var=last_cluster value=$scoredSkill.cluster_name}
                                        {assign var=last_knowledge_skill value=$scoredSkill.knowledge_skill}
                                        {assign var=isFirst value=false}

                                        {* assign var=last_skill_id value=$skill_id *}
                                    {/foreach}




                                    <!--/tbody-->
                                    </table>
                                {if $isNewAction}
                                </div><!-- visibility: nieuwe actie -->
                                {else}
                                </div><!-- visibility: edit actie -->
                                {/if}
                            </div><!-- show_info_comp -->
                        </td>
                    </tr>
                </table>
        </div><!-- show_info_comp -->


{else}{* ! $elementCount > 0*}
    <div><!-- edit_skills_data -->
        <p style="font-weight: normal;">{'NO_RELATED_COMPETENCES'|TXT_UCF}</p>
    </div>
{/if}{* $elementCount *}


{* uitvoeren hoofdfunctie van de template met de verwachtte parameters *}
{* als {funtie }*}
{*skillsByActionsEdit isNewAction=$newAction
                     scoredSkills=$scoredSkills
                     prevSkills=$prevSkills
                     actionSkills=$actionSkills*}
<!-- pdpSkillsByActionEdit.tpl -->