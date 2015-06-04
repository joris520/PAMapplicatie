{* te vullen vars:
    - skillActions: array met action names
    - useLink
*}
<!-- pdpActionsBySkillView.tpl -->
{assign var=elementCount value=$skillActions|count}{* hoeveel elementen *}
{if $elementCount > 0}
    <ul style="margin: 0px; padding: 0px; list-style-position:inside;">
        {foreach $skillActions as $skillAction}
            <li>
                {if $useLink}
                <a href="" onclick="xajax_moduleEmployees_pdpActionData_deprecated('{$skillAction.ID_PDPEA}','{$skillAction.ID_E}', '{$skillAction.ID_KSP}');return false;">
                    {$skillAction.action_name}
                </a>;
                {else}
                    {$skillAction.action_name};
                {/if}
                {'DEADLINE_DATE'|TXT_UCF}: {$skillAction.end_date};
                {strip}
                {if $skillAction.is_completed != 0}
                    {'COMPLETED'|TXT_UCF}
                {else}
                    <strong>{'NOT_COMPLETED'|TXT_UCF}</strong>
                {/if}
                {/strip}
            </li><!-- ID_PDPEA: {$skillAction.ID_PDPEA} '-->
        {/foreach}
    </ul>
{else}
    {'NO_RELATED_ACTIONS'|TXT_UCF}
{/if}
<!-- /pdpActionsBySkillView.tpl -->