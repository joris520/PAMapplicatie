{function name=writeScale5 labelName='' selected=''}
{strip}
        {* loop attribuut neemt hoogste waarde nooit mee *}
        {section name=scale5 start=1 loop=6 max=5 step=1}<input type="radio" name="{$labelName}" value="{$smarty.section.scale5.index}" {if $selected == $smarty.section.scale5.index}checked{/if} />{$smarty.section.scale5.index} {/section}
{/strip}
{/function}

{writeScale5 labelName=$selectName selected=$selectedValue}