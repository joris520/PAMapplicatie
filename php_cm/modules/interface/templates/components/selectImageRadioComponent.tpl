<!-- selectImageRadioComponent.tpl -->
{* inputName *}
{* $values *}
{* $currentValue *}
{* converter *}
{foreach $values as $value}
    {assign var=display value=call_user_func($converter|cat:'::displayImage',$value)}
    {assign var=title value=call_user_func($converter|cat:'::description',$value)}
    <input  id="{$inputName}_{$value}" type="radio" name="{$inputName}" value="{$value}"  {if $value == $currentValue} checked {/if}>
    <label for="{$inputName}_{$value}"{if !empty($title)} title="{$title}"{/if}>{$display}</label><br />
{/foreach}
<!-- /selectImageRadioComponent.tpl -->
