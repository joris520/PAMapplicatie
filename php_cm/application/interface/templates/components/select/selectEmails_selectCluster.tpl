{* smarty *}

    {function name=writeEmailOption firstname='' lastname='' email='' cluster=''}
        {if $cluster == '2'}
            *&nbsp;
        {/if}
        {if $lastname == ''}
            {if $firstname == ''}
                {$email}
            {else}
                {$firstname} &nbsp; &nbsp; ({$email})
            {/if}
        {else}
            {if $firstname == ''}
                {$lastname} &nbsp; &nbsp; ({$email})
            {else}
                {$lastname}, {$firstname} &nbsp; &nbsp; ({$email})
            {/if}
        {/if}

    {/function}

    <select name="personIDs" id="personIDs" ondblclick="switchSelectBox('add', 'personIDs', 'personIDs_selected', 'selected_ID_PDs'); return false;" size="10" multiple="multiple" style="width:250px;">
        {foreach $entries as $entry}
            <option value="{$entry.ID_PD}">{writeEmailOption firstname=$entry.firstname lastname=$entry.lastname email=$entry.email cluster=$entry.ID_EC}</option>
        {/foreach}
    </select>