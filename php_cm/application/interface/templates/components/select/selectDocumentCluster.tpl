{* smarty *}
{* select_field_cluster, clusters, selected_cluster_id *}
{if $clusters|@count == 0}
    {'NO_ATTACHMENT_CLUSTERS_AVAILABLE'|TXT_UCF}
{else}
    <select name="{$select_field_cluster}" id="{$select_field_cluster}" >
        <option value="">- {'SELECT'|TXT_UCF} -</option>
        {foreach $clusters as $cluster}
            {if $selected_cluster_id == $cluster.ID_DC}
                {assign var="selected" value=' selected'}
            {else}
                {assign var="selected" value=''}
            {/if}
            <option value="{$cluster.ID_DC}" {$selected}>{$cluster.document_cluster}</option>
        {/foreach}
    </select>
{/if}