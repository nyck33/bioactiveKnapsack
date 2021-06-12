$(document).on('click', '#delCheckedBtn', function(){
    var tbodyRef = document.getElementById('disease-table').getElementsByTagName('tbody')[0];
    var numRows = tbodyRef.rows.length;

    for(var i=0; i<numRows; i++) {
        var row = tbodyRef.rows[i];
        var chbox = row.cells[0].getElementsByTagName('input')[0];
        if (chbox.checked === true) {
            tbodyRef.deleteRow(i);
        }
    }
});

$(document).on('click', '#delCheckedBtnFood', function(){
    var tbodyRef = document.getElementById('food-table').getElementsByTagName('tbody')[0];
    var numRows = tbodyRef.rows.length;

    for(var i=0; i<numRows; i++) {
        var row = tbodyRef.rows[i];
        var chbox = row.cells[0].getElementsByTagName('input')[0];
        if (chbox.checked === true) {
            tbodyRef.deleteRow(i);
        }
    }
});

$(document).on('click', '#delCheckedBtnMet', function(){
    var tbodyRef = document.getElementById('metabollite-table').getElementsByTagName('tbody')[0];
    var numRows = tbodyRef.rows.length;

    for(var i=0; i<numRows; i++) {
        var row = tbodyRef.rows[i];
        var chbox = row.cells[0].getElementsByTagName('input')[0];
        if (chbox.checked === true) {
            tbodyRef.deleteRow(i);
        }
    }
});



