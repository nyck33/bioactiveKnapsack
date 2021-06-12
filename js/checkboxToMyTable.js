/////////////////////////////////////////////////////////////////////////
//eventlistener for checkboxes, add to my tables then have submit button
//call on submit disease
//add event to all checboxes on page
/*
document.getElementById("addMyDiseaseBtn").addEventListener('click', function(){
    var colToValDict = checkForChecked('disease-table');
    addToMyTable(colToValDict);
});
*/
$(document).on('click', '#addMyDiseaseBtn', function(){
    var colToValDict = checkForChecked('disease-table');
    addToMyTable(colToValDict);
});
function checkForChecked(table_name){
    var colToValDict = {};
    var table = document.getElementById(table_name);
    console.log(table);
    var tHead = table.getElementsByTagName('thead');
    console.log(tHead);
    var tHs = document.querySelectorAll('#disease-table > thead > th');
    console.log(tHs);

    var tBody = table.getElementsByTagName('tbody');
    console.log(tBody);
    //var rows = table.getElementsByTagName('tr');
    var rows = document.querySelectorAll('#disease-table >tbody > tr');
    console.log(rows);
    //headers

    //init to empty str
    for(header in tHs){
        colToValDict[header] = "";
    }

    for(row in rows) {
        var cbox = table.getElementsByTagName('input');
        var tdElements = document.querySelectorAll('#disease-table > tbody > tr > td');
        if (cbox.checked == true) {
            //put the td values into dict including select col
            for (var i = 0; i < tHeaders.length; i++) {
                colToValDict[tHeaders[i]] = tdElements[i];
            }
        }
    }
    return colToValDict;
}

function addToMyTable(colToValDict){

    var table_type = 'disease'
    var table_name = "my-" + table_type + "-table";
    var table_div = document.getElementById(table_name + "-responsive")
    var table = document.getElementById(table_name);
    var num_rows = table.rows.length;
    //no rows yet
    if (num_rows === 0) {
        //put button, download as csv
        var downloadCsvBtn = document.createElement('button');
        downloadCsvBtn.setAttribute('id', 'addMyDiseaseBtn');
        downloadCsvBtn.setAttribute('type', 'submit');
        downloadCsvBtn.setAttribute('class', 'btn btn-primary');
        downloadCsvBtn.textContent = 'download CSV';
        insertAfter(downloadCsvBtn, table_div);
        //add upload to mysql button
        var saveToProfileBtn = document.createElement('button');
        saveToProfileBtn.setAttribute('id', 'addMyDiseaseBtn');
        saveToProfileBtn.setAttribute('type', 'submit');
        saveToProfileBtn.setAttribute('class', 'btn btn-primary');
        saveToProfileBtn.textContent = 'save to profile';
        insertAfter(saveToProfileBtn, table_div);

        var thead = table.createTHead();
        var row = thead.insertRow(0);
        //add header
        for (var key in colToValDict){
            let cell = row.insertCell(-1);
            let newText = document.createTextNode(key);
            cell.appendChild(newText);
        }
        //var tbody = table.createTBody(); and value rows
        var tbody = document.createElement('tbody');
        table.append(tbody);
        var row = tbody.insertRow(-1);

        for(let key in colToValDict){
            let cell = row.insertCell(-1);
            let val = colToValDict[key];
            let newText = document.createTextNode(val);
            cell.appendChild(newText);

        }
        //add heading/title for table
        var table_heading = document.createElement('h3');
        //just use my-disease-table
        var heading_text = document.createTextNode(table_name);
        table_heading.appendChild(heading_text);
        //get the div above table
        var table_div = document.getElementById("my" + table_type + "-tbl-responsive") ;
        table_div.insertBefore(table_heading, table_div.children[0]);
    }
    else{
        var tbodyRef = document.getElementById(table_name).getElementsByTagName('tbody')[0];
        //console.log(tbodyRef);
        var row = tbodyRef.insertRow(-1);
        for(let key in colToValDict) {
            let cell = row.insertCell(-1);
            let newText = document.createTextNode(colToValDict[key]);
            cell.appendChild(newText);
        }
    }

};
////////////////////////////////////////////////////////////////////
//
