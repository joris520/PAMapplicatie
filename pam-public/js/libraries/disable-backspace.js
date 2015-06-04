$(document).keydown(function(e) {
    var nodeName = e.target.nodeName.toLowerCase();

    if (e.which === 8) {
        if ((nodeName === 'input' && (e.target.type === 'text' || e.target.type === 'password')) ||
             nodeName === 'textarea') {
            // do nothing
        } else {
            e.preventDefault();
        }
    }
});