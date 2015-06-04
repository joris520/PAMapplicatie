{* smarty *}
{* authorisations *}
{if $authorisations|@count > 0}
    {foreach $authorisations as $authorisation}
        {if $authorisation.selected_id == $authorisation.level_id}
            {assign var="checked" value='checked="checked"'}
        {else}
            {assign var="checked" value=''}
        {/if}
        <label><input type="checkbox" name="{$authorisation.input_field_id}"
                        id="{$authorisation.input_field_id}" {$checked}
                        value="{$authorisation.level_id}">&nbsp;{$authorisation.display_name}</label>
        <br>
    {/foreach}
{/if}