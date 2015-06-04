

//function switchSelectedMaster(unselect_id, select_id)
//{
//    $('#'+unselect_id).removeClass('hilite-row');
//    $('#'+select_id).addClass('hilite-row');
//}

function selectRow(selected_row)
{
    $('#scrollDiv').find('.divLeftWbg').each(function(){
        $(this).removeClass("divLeftWbg").addClass('divLeftRow');
    });
    $('#' + selected_row).addClass('divLeftWbg');
}

function switchSelectedMaster(master_group_id, master_element_id)
{
//    console.log($('#' + master_group_id).find('.hilite-row'));
    $('#' + master_group_id)
        .find('.hilite-row')
            .removeClass('hilite-row')
        .end();
    $('#' + master_element_id).addClass('hilite-row');
}

function removeSelectedMaster(master_group_id)
{
//    console.log($('#' + master_group_id).find('.hilite-row'));
    $('#' + master_group_id)
        .find('.hilite-row')
            .removeClass('hilite-row');
}

function hilite_new_element()
{
    $('.short_hilite').delay(200).slideDown('slow',function(){
        $(this).fadeIn('slow', function() {
            $(this).delay(500*6).removeClass('short_hilite', 1000);
        });
    });
}

function fadeInDetail(fade_element_id)
{
    $('#'+fade_element_id).delay(50).slideDown('slow', function(){
        $(this).fadeIn('slow');
    });
}

function fadeOutDetail(fade_element_id, content_element_id)
{
    $('#'+fade_element_id).fadeOut('slow', function(){
        $(this).slideUp('slow', function() {
            $('#'+content_element_id).text('')
        });
    });
}
//
//function activateRow(row_element)
//{
////    console.log($('#' + row_element_id).find('.activeRow'));
//    $('#' + row_element).addClass('hoveredRow').find('.activeRow').addClass('activatedRow');
//}

function activateThisRow(row_element, hoverClass)
{
    hoverClass  = hoverClass || 'hoveredRow';
    $(row_element).addClass(hoverClass).find('.activeRow').addClass('activatedRow');
}

function deactivateThisRow(row_element, hoverClass)
{
    hoverClass  = hoverClass || 'hoveredRow';
    $(row_element).removeClass(hoverClass).find('.activeRow').removeClass('activatedRow');
}

function activateEditButtons(activate_element_id)
{
    $('#' + activate_element_id)
        .find('.activeRow')
            .removeClass('activeRow')
        .end();
}

function addClassToElement(change_element_id, element_class)
{
    $('#' + change_element_id).addClass(element_class);
}

function removeClassFromElement(change_element_id, element_class)
{
    $('#' + change_element_id).removeClass(element_class);
}

//function deactivateEditButtons(deactivate_element_id)
//{
//    $('#'+deactivate_element_id).removeClass('activedEditButtons');
//}

function toggleAllCommentRows(blockId)
{
    $('#' + blockId)
        .find('.comment-row')
            .toggle()
        .end();
}

function toggleCommentRow(blockId, rowId)
{
    $('#' + blockId)
        .find('.comment-row#' + rowId)
            .toggle()
        .end();
    $('#' + blockId)
        .find('.comment-row#spacer_' + rowId)
            .toggle()
        .end();
}

function togglePrintOption(optionId)
{
    $('#print_options')
        .find('.print_option_detail_' + optionId)
            .toggle()
        .end();
}


// algemene toggle functie
function toggleVisilibityById(elementId)
{
    $('#' + elementId).toggle();

}

function hideElementById(elementId)
{
    $('#' + elementId).hide();

}
