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
///////////////////////////////////////////////////
function groupDictionariesByKeys(resArrofArrs) {
    // Helper function to generate a key based on the dictionary's keys
    function generateKey(dict) {
        return Object.keys(dict).sort().join('_');
    }

    // The object to hold the grouped dictionaries
    const groupedDicts = {};

    // Iterate over the array of dictionaries
    resArrofArrs.forEach(dict => {
        // Generate a key for the current dictionary
        const key = generateKey(dict);
        
        // If the key is not already in the groupedDicts, add it with an empty array
        if (!groupedDicts[key]) {
            groupedDicts[key] = [];
        }

        // Push the current dictionary into the appropriate group in groupedDicts
        groupedDicts[key].push(dict);
    });

    return groupedDicts;
}

// Usage example
// This should replace the direct assignment of resArrofArrs in your makeTables function
//var groupedResArrofArrs = groupDictionariesByKeys(resArrofArrs);
// Now, you can iterate over groupedResArrofArrs to create tables for each group
function makeTables(resArrofArrs) {
    // Call the helper function to group dictionaries
    var groupedDictionaries = groupDictionariesByKeys(resArrofArrs);

    // Clear the existing results
    var top_div = document.getElementById('db-search-result');
    top_div.innerHTML = '';

    // Iterate over the grouped dictionaries to create a table for each key
    for (var groupKey in groupedDictionaries) {
        var groupArray = groupedDictionaries[groupKey];

        // Create a container div for the table
        var enclose_div = document.createElement('div');
        enclose_div.className = 'table-responsive';
        top_div.appendChild(enclose_div);

        // Create the table
        var table = document.createElement('table');
        table.id = 'group-table-' + groupKey; // Assign a unique ID based on the groupKey
        table.className = 'table table-hover';
        enclose_div.appendChild(table);

        // Create thead and tbody elements
        var thead = table.createTHead();
        var tbody = table.createTBody();

        // Set up the header row based on the first item's keys
        var headerRow = thead.insertRow();
        var headers = Object.keys(groupArray[0]);
        headers.forEach(header => {
            let th = document.createElement('th');
            th.textContent = header.replace(/([A-Z])/g, ' $1').trim(); // Add space before capital letters for better readability
            headerRow.appendChild(th);
        });

        // Iterate over the array of dictionaries in the current group
        groupArray.forEach(item => {
            var row = tbody.insertRow();
            headers.forEach(header => {
                let cell = row.insertCell();
                cell.textContent = item[header]; // Access the value by key
            });
        });

        // ...

        // After the table is created and populated with data rows, you add the download CSV button
        var downloadCsvBtn = document.createElement('a');
        downloadCsvBtn.setAttribute('class', 'btn btn-secondary');
        downloadCsvBtn.setAttribute('download', groupKey + '-results.csv');
        downloadCsvBtn.setAttribute('href', '#');
        downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, '" + table.id + "');");
        downloadCsvBtn.setAttribute('role', 'button');
        downloadCsvBtn.textContent = 'Download CSV';
        insertAfter(downloadCsvBtn, enclose_div); // Use insertAfter function if defined, or appendChild if not

// ...

    }
}
//////////////////////////////////////////////////

/* 
//this version does not account for different tables with different columns
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
*/