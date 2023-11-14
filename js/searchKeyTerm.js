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
function makeTables(resArrofArrs) {
    // Clear the existing results
    var top_div = document.getElementById('db-search-result');
    top_div.innerHTML = '';

    // Create a container div for the table
    var enclose_div = document.createElement('div');
    enclose_div.className = 'table-responsive';
    top_div.appendChild(enclose_div);

    // Create the table
    var table = document.createElement('table');
    table.className = 'table table-hover';
    enclose_div.appendChild(table);

    // Create thead and tbody elements
    var thead = table.createTHead();
    var tbody = table.createTBody();

    // Set up the header row based on the desired order
    var headerRow = thead.insertRow();
    var headers = ['id', 'en_name', 'disease', 'food', 'metabollite', 'healthEffect'];
    headers.forEach(header => {
        let th = document.createElement('th');
        th.textContent = header.replace(/([A-Z])/g, ' $1').trim(); // Add space before capital letters for better readability
        headerRow.appendChild(th);
    });

    // Iterate over the array of arrays (resArrofArrs)
    resArrofArrs.forEach(item => {
        var row = tbody.insertRow();
        headers.forEach(header => {
            let cell = row.insertCell();
            cell.textContent = item[header]; // Access the value by key
        });
    });

    // Add the download csv button
    var downloadCsvBtn = document.createElement('a');
    downloadCsvBtn.setAttribute('class', 'btn btn-secondary');
    downloadCsvBtn.setAttribute('download', 'results.csv');
    downloadCsvBtn.setAttribute('href', '#');
    downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, 'disease-table');");
    downloadCsvBtn.setAttribute('role', 'button');
    downloadCsvBtn.textContent = 'Download CSV';
    enclose_div.appendChild(downloadCsvBtn);
}
