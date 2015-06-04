<!-- selectOptionsComponent.tpl -->
{* $values *}
{* $currentValue *}
{* converter *}
{* required *}
{* subject *}
{if !$required}
    <option value="">- {'SELECT'|TXT_LC}{if !empty($subject)} {$subject}{/if} -</option>
{/if}
{foreach $values as $value}
    {assign var=display value=call_user_func($converter|cat:'::display',$value)}
    {assign var=title value=call_user_func($converter|cat:'::description',$value)}
    <option value="{$value}" {if $currentValue == $value}selected{/if}{if !empty($title)} title="{$title}"{/if}>{$display}</option>
{/foreach}
<!-- /selectOptionsComponent.tpl -->
