<!-- tableRowRadioComponent.tpl -->
{* inputName *}
{* option *}
{* values *}
{* converter *}
{* indentation *}
{* initialVisible *}
{* currentValue *}
{if !$initialVisible}
{assign var=initialHiddenClass value='hidden-info'}
{/if}
{foreach $values as $value}
<tr class="print_option_detail_{$option} {$initialHiddenClass}">
    <td style="padding-left:{$indentation};">
        {assign var=display value=call_user_func($converter|cat:'::input',$value)}
        {assign var=title value=call_user_func($converter|cat:'::description',$value)}
        <input  id="{$inputName}_{$value}" type="radio" name="{$inputName}" value="{$value}" {if $value == $currentValue}checked{/if}>
        <label for="{$inputName}_{$value}"{if !empty($title)} title="{$title}"{/if}>{$display}</label>
    </td>
</tr>
{/foreach}
<!-- /tableRowRadioComponent.tpl -->