<!-- printOptionComponent.tpl -->
{* inputName *}
{* options *}
{* checkedOptions *}
{* converter *}
{* detailOptions *}
{* optionDetailTemplate *}
{foreach $options as $option}
    {* todo:function*}
    {if in_array($option, $checkedOptions)}
    {assign var=checkedAttribute value='checked'}
    {else}
    {assign var=checkedAttribute value=''}
    {/if}
    <tr>
        <td>
            {assign var=display value=call_user_func($converter|cat:'::input',$option)}
            <input id="{$inputName}_{$option}" name="{$inputName}_{$option}"  type="checkbox" {$checkedAttribute} value="{$option}" onClick="togglePrintOption({$option}); return true;">
            <label for="{$inputName}_{$option}">{$display}</label>
        </td>
    </tr>
    {assign var=printOptionDetailInterfaceObject value=$interfaceObject->getPrintOptionDetail($option)}
    {if !empty($printOptionDetailInterfaceObject)}
        {$printOptionDetailInterfaceObject->fetchHtml()}
    {/if}
{/foreach}
<!-- /printOptionComponent.tpl -->
