{* te vullen vars:
    - actionSkills: array met skill names
*}
<!-- pdpSkillsByActionView.tpl -->
{strip}
    {foreach $actionSkills as $actionSkill}
        <span>
            {if !$actionSkill@first},&nbsp;{/if}
            {$actionSkill.skill_name}
        </span>
    {foreachelse}
        {'NO_RELATED_COMPETENCES'|TXT_UCF}
    {/foreach}
{/strip}
<!-- /pdpSkillsByActionView.tpl -->