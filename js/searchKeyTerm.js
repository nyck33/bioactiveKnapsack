/*
return results as
fill php array with
 */
$(document).ready(function(){
    $('#btn-key-term').click(function(){
        showSearchResults();
    });
});
function showSearchResults(){
        var search_term = document.getElementById('input-key-term').value;
        //append to this div
        var results_div = document.getElementById('db-search-result');

        var controller = 'controller.php';

        $.post(controller,
        {
            username: 'User',
                page: 'SpaPage',
            command: 'searchDB',
            searchterm: search_term
        },
        function(results_json, status){
            //alert(results_json);
            var parsed = JSON.parse(results_json);
            //console.log(parsed);
            //results_obj = parsed[0][0];
            //console.log(results_obj);
            makeTables(parsed);
        });
};
//////////////////////////////////////////////////////
function insertAfter(newNode, referenceNode){
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
};
//////////////////////////////////////////////////

/* arr of arrs of obj form [[obj,obj,obj], [obj], [obj,obj]]
* make table*/
function makeTables(resArrofArrs){
    var top_div = $('#db-search-result');
    var count = 0;

    resArrofArrs.forEach(function(matchesArr, i) {
        var tableId = "table" + count;
        var csvName = count + ".csv";
        var enclose_div = $('<div>').addClass('table-responsive');
        var table = $('<table>').addClass('table table-hover').attr('id', tableId);
        var downloadCsvBtn = $('<a>').addClass('btn btn-secondary').attr({
            'download': csvName,
            'href': '#',
            'onclick': "return ExcellentExport.csv(this, 'disease-table');",
            'role': 'button'
        }).text('download csv');

        matchesArr.forEach(function(matchRow, j) {
            var row = $('<tr>');
            for (var key in matchRow) {
                var cell = $('<td>').text(matchRow[key]);
                row.append(cell);
            }
            table.append(row);
        });

        enclose_div.append(downloadCsvBtn, table);
        top_div.append(enclose_div);
        count++;
    });
};

/*
The makeTables function in searchKeyTerm.js is responsible for creating tables from the search results. It seems to be working with an array of arrays, where each sub-array represents a row of data to be displayed in the table.

Here are some potential issues and refactorings:

1. Parsing JSON: The showSearchResults function parses the JSON response from the server. If the server's response is not in the expected format, this could cause issues. Ensure that the server is returning a JSON string that can be parsed into an array of arrays.

2. Creating Elements: The makeTables function creates a lot of elements manually. This can be error-prone and hard to manage. Consider using a library like jQuery to simplify this process. For example, instead of creating a table row and cells manually, you could use jQuery's append function to add HTML strings to the table.

3. Appending Elements: The function seems to be appending elements in a somewhat convoluted way. For example, it creates a tableHeading element, then inserts it before the first child of enclose_div. It would be simpler to append the tableHeading to enclose_div directly.

4. Error Handling: There doesn't seem to be any error handling in the showSearchResults function. If the AJAX request fails or returns an error, the function won't handle this gracefully. Consider adding a .fail handler to the AJAX request to handle any errors.

Here's a simplified version of the makeTables function using jQuery:
*/