<!-- employeePdpActionCompetenceSelectView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=inputId     value=$interfaceObject->getCheckboxPrefix()|cat:$valueObject->getId()}

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
    <tr>
        <td style="padding-left: 20px; width: 25px;">
            {writeCheckbox input_id=$inputId
                        is_selected=$interfaceObject->isSelected()}
        </td>
        <td>
            {writeLabel label_name=$valueObject->getCompetenceName()
                        input_id=$inputId
                        is_selected=$interfaceObject->isSelected()}
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
<!-- /employeePdpActionCompetenceSelectView.tpl -->