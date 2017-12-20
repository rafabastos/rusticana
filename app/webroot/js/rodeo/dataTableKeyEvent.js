$(document).keydown(function (event) {
    var currentRow = $(".row_selected").get(0);
    console.log('Tratando de cambiar');
    switch(event.keyCode)
    {
        //arrow down
        case 40:
            $(currentRow).next().addClass("row_selected");
            $(currentRow).removeClass("row_selected");
            break;
        //arrow up
        case 38:
            $(currentRow).prev().addClass("row_selected");
            $(currentRow).removeClass("row_selected");
            break;

    }
});