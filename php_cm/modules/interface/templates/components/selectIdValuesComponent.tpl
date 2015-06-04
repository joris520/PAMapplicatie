<!-- selectIdValuesComponent.tpl -->
{* idValue (array of IdValue) *}
{* currentValue (id) *}
{* required *}
{if !$required}
    <option value="">- {'SELECT'|TXT_LC}{if !empty($subject)} {$subject}{/if} -</option>
{/if}
{foreach $idValues as $idValue}
<option value="{$idValue->getDatabaseId()}" {if $currentValue == $idValue->getDatabaseId()}selected{/if}>{$idValue->getValue()}</option>
{/foreach}
<!-- /selectIdValuesComponent.tpl -->