$(document).ready(function(){
	window.keyNavAllowed = false;
});


// Bind up and down keys
$(document).keydown(function(e){
    if(window.keyNavAllowed) {
        var performEval = false;
        var currentRowId = $('#' + window.currentRow);
        switch(e.which) {
            case 38: // Up
                if (currentRowId.prev().attr('id')) {
                    // Update currentRow for the next key stroke
                    window.currentRow = currentRowId.prev().attr('id');
                    performEval = true;
                }
                e.preventDefault();
            break;
            case 40: // Down
                if (currentRowId.next().attr('id')) {
                    // Update currentRow for the next key stroke
                    window.currentRow = currentRowId.next().attr('id');
                    performEval = true;
                }
                e.preventDefault();
            break;
        }
        if (performEval) {
            // retrieve and eval XAJAX function form onclick
            var onClick = $('#' + window.currentRow).find('a').attr('onclick');
            eval(onClick);
            updateScrollPosition();
        }
    }
});

// keyNavAllowed is set to true if the user clicks on an element with the class 'divLeftRow'.
// If a click is registered elsewhere, keyNavAllowed is set to false.
// This is to prevent accidental navigation while in edit modus.
$(document).click(function(event) {
    var clickId = event.target.id;
    var parentId = $('#' + clickId).parent().parent().parent().attr('id');
    if($('#' + parentId).hasClass('divLeftRow')) {
        window.keyNavAllowed = true;
    } else {
        window.keyNavAllowed = false;
    }
});
// Set the starting point for up and down navigation with the keys
function setCurrentRow (employeeId) {
    window.currentRow = 'rowLeftNav' + employeeId;
}
// Set scroll position of #scrolDiv so that currently selected row is always visible in the screen
function updateScrollPosition () {
    var rowCount    = $('#' + window.currentRow).prevAll().length;
    var rowHeight   = $('#' + window.currentRow).outerHeight();
    $("#scrollDiv").scrollTop((rowCount * rowHeight) - rowHeight);
}