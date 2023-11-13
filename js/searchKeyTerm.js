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
    //console.log(resArrofArrs);
    var arrOfObjects = [];
    //append each enclosing div of table as child this top_div
    var top_div = document.getElementById('db-search-result');
    //each row of matches is a dict
    var count=0;
    //make new table for each matchesArr
    //appendChild to an enclosing responsive div
    //for(var matchesArr in resArrofArrs){
    for(var i=0; i<resArrofArrs.length; i+=1){
        var matchesArr = resArrofArrs[i];
        //console.log(matchesArr);
        //for excellentExport
        var csvName = count + ".csv";
        var tableId = "table" + count;
        var enclose_div = document.createElement('div');
        enclose_div.setAttribute('class', 'table-responsive' );
        //the actual table
        var table= document.createElement('table');
        table.setAttribute('class', 'table table-hover');
        table.setAttribute('id', tableId);
        //add button to download csv at bottom of enclosing div
        //<a download="diseases.csv" href="#" onclick="return ExcellentExport.csv(this, 'disease-table');">Export to CSV</a>
        var downloadCsvBtn = document.createElement('a');
        downloadCsvBtn.setAttribute('class', 'btn btn-secondary');
        downloadCsvBtn.setAttribute('download', csvName);
        downloadCsvBtn.setAttribute('href', '#');
        downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, 'disease-table');");
        downloadCsvBtn.setAttribute('role', 'button');
        downloadCsvBtn.textContent = 'download csv';
        //todo: need jQuery for dyanically created DOM elements?
        //insertAfter(downloadCsvBtn, enclose_div);
        //enclose_div.insertAfter(downloadCsvBtn);
        //$(enclose_div).append(downloadCsvBtn);
        //enclose_div.appendChild(downloadCsvBtn);
        //downloadCsvBtn.appendTo($(enclose_div));
        //make a table from matchesArr, each matchRow is a table row
        //for(var matchRow in matchesArr){
        var rowCount = 0;
        for(var j=0; j<matchesArr.length; j+=1){
            var matchRow = matchesArr[j];
            //console.log(matchRow)
            var tbody;
            var row;

            if(rowCount==0) {
                //make new thead
                var thead = table.createTHead();
                row = thead.insertRow(0);
                for (var h in matchRow) {
                    let cell = row.insertCell(-1);
                    let newText = document.createTextNode(h);
                    cell.appendChild(newText);
                }
                //first value row
                tbody = document.createElement('tbody');
                table.append(tbody);
                row = tbody.insertRow(-1);

                for(let key in matchRow){
                    let cell = row.insertCell(-1);
                    let val = matchRow[key];
                    let newText = document.createTextNode(val);
                    cell.appendChild(newText);
                }
                //add heading
                var tableHeading = "table " + count;
                var table_heading = document.createElement('h6');
                var heading_text = document.createTextNode(tableHeading);
                table_heading.appendChild(heading_text);
                enclose_div.insertBefore(table_heading, enclose_div.children[0] );
            }
            else{
                //cannot do this dynamically
                //var tbodyRef = document.getElementById(tableId).getElementsByTagName('tbody')[0];
                row = tbody.insertRow(-1);
                for(let key in matchRow) {
                    let cell = row.insertCell(-1);
                    let newText = document.createTextNode(matchRow[key]);
                    cell.appendChild(newText);
                    }
            }
            rowCount+=1;
        }
        //append to top div at -1 index
        top_div.appendChild(table);
        count+=1;

    }
};
