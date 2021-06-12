
///////////////////////////////////////////////////////////////////////////////
//helpers
//https://stackoverflow.com/a/27814032/13865853
function createElementFromHTML(htmlString, element){
    element.innerHTML = htmlString.trim();
    return element;  //.childNodes;
};

//takes a name of disease, food or metabollite, returns a link Object
function createLink(disFoodMet, hint=""){
    var gLink = document.createElement('a');
    var linkText = document.createTextNode(disFoodMet);
    gLink.appendChild(linkText);
    gLink.title = "link-" + disFoodMet;
    gLink.href = "https://www.google.ca/search?q=" + disFoodMet + "+" + hint;
    gLink.target = "_blank";

    return gLink;
}
///////////////////////////////////////////////////////////////////
//utility to add button after table
function insertAfter(newNode, referenceNode){
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
};
///////////////////////////////////////////////////////////////////////////////

//for dropdown tables
//1. disease
$(document).ready(function(){
    $('#disease-btn').click(function(){
        showDisease();
    });
});

function showDisease() {

    //var disease = $("#disease-dropdown:selected").text();
    //var disease = $("#disease-dropdown:selected").val();
    var disease_dropdown = document.getElementById("disease-dropdown")
    var disease = disease_dropdown.options[disease_dropdown.selectedIndex].text;
    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'search-disease',
            search_term: disease
        },
        function (disease_json, status) {
            //json is a string
            var parsed = JSON.parse(disease_json);
            disease_dict = parsed[0];

            makeDiseaseTable(disease_dict);

        }); //'json');
};

//also want add to mytables button
//also want add to mytables button
function makeDiseaseTable(disease_dict){
    var checkbox_marker = 'Disease';
    var table = document.getElementById('disease-table');
    var num_rows = table.rows.length;
    var disease_name = disease_dict['Disease'];
    var no_spaces = disease_name.split(' ').join('');
    var check_name = `check-${no_spaces}`;
    //need to add key-value for check column header and check column value

    /*
    var cboxHTMLString = "<input type='checkbox' class='custom-control-input'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>"
        + "<label class='custom-control-label' for='customCheck" + no_spaces + "'+>"
        + "</label>";
    */
    var cboxHTMLString = "<input type='checkbox'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>";


    var div = document.createElement('div');
    div.setAttribute("class", "custom-control custom-checkbox");
    var checkbox_div = createElementFromHTML(cboxHTMLString, div);


    var d_dict = {Select: checkbox_div};
    //iterate disease_dict and add k,v to d_dict
    for(let key in disease_dict) {
        var new_key = key;
        var new_val = disease_dict[key];
        d_dict[new_key] = new_val;
    }
    //hint for extra url parameter
    var url_hint = "";
    //no rows yet
    if (num_rows === 0) {
        //add button at btm of div
        var table_div = document.getElementById('dis-tbl-responsive');
        var addToMyTableBtn = document.createElement('button');
        addToMyTableBtn.setAttribute('id', 'addMyDiseaseBtn');
        addToMyTableBtn.setAttribute('type', 'submit');
        addToMyTableBtn.setAttribute('class', 'btn btn-primary');
        addToMyTableBtn.textContent = 'coming soon';
        insertAfter(addToMyTableBtn, table_div);//table_div.appendChild(addToMyTableBtn);

        //add another button
        //<a download="diseases.csv" href="#" onclick="return ExcellentExport.csv(this, 'disease-table');">Export to CSV</a>
        var downloadCsvBtn = document.createElement('a');
        downloadCsvBtn.setAttribute('class', 'disease btn btn-secondary');
        downloadCsvBtn.setAttribute('download', 'diseases.csv');
        downloadCsvBtn.setAttribute('href', '#');
        downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, 'disease-table');");
        downloadCsvBtn.setAttribute('role', 'button');
        downloadCsvBtn.textContent = 'download csv';
        insertAfter(downloadCsvBtn, table_div);//table_div.appendChild(addToMyTableBtn);
        //button to delete rows
        var deleteCheckedBtn = document.createElement('button');
        deleteCheckedBtn.setAttribute('id', 'delCheckedBtn');
        deleteCheckedBtn.setAttribute('type', 'submit');
        deleteCheckedBtn.setAttribute('class', 'btn btn-danger');
        deleteCheckedBtn.textContent = 'delete selected';
        insertAfter(deleteCheckedBtn, table_div);
        //make new thead
        var thead = table.createTHead();
        var row = thead.insertRow(0);
        for (var h in d_dict){
            let cell = row.insertCell(-1);
            let newText = document.createTextNode(h);
            cell.appendChild(newText);
        }
        //var tbody = table.createTBody();
        var tbody = document.createElement('tbody');
        table.append(tbody);
        var row = tbody.insertRow(-1);

        for(let key in d_dict){
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
                //add eventListener???
            }
            else if(key==='Disease' || key==='Name'){
                if(key==='Disease'){
                    url_hint = "illness";
                }
                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
            }
            else{
                let val = d_dict[key];
                let newText = document.createTextNode(val);
                cell.appendChild(newText);
            }
        }
        //add heading
        var table_heading = document.createElement('h3');
        var heading_text = document.createTextNode("Disease Table");
        table_heading.appendChild(heading_text);

        table_div.insertBefore(table_heading, table_div.children[0] );
    }
    else{
        var tbodyRef = document.getElementById('disease-table').getElementsByTagName('tbody')[0];
        var row = tbodyRef.insertRow(-1);
        for(let key in d_dict) {
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
            }
            else if(key==='Disease' || key=='Name'){
                if(key==='Disease'){
                    url_hint = "illness";
                }
                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
                cell.appendChild(gLink);
            }
            else {
                let newText = document.createTextNode(d_dict[key]);
                cell.appendChild(newText);
            }
        }
    }
};

////////////////////////////////////////////////////////////////////////////
//new food functions
$(document).ready(function(){
    $('#food-btn').click(function(){
        showFood();
    });
});

function showFood() {

    //var food = $("#food-dropdown:selected").text();
    //var food = $("#food-dropdown:selected").val();
    var food_dropdown = document.getElementById("food-dropdown")
    var food = food_dropdown.options[food_dropdown.selectedIndex].text;
    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'search-food',
            search_term: food
        },
        function (food_json, status) {
            //json is a string
            var parsed = JSON.parse(food_json);
            food_dict = parsed[0];

            makeFoodTable(food_dict);

        }); //'json');
};

function makeFoodTable(food_dict){
    var checkbox_marker = 'food';
    var table = document.getElementById('food-table');
    var num_rows = table.rows.length;
    var food_name = food_dict['Scientific Name'];
    var no_spaces = food_name.split(' ').join('');
    var check_name = `check-${no_spaces}`;
    //need to add key-value for check column header and check column value

    /*
    var cboxHTMLString = "<input type='checkbox' class='custom-control-input'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>"
        + "<label class='custom-control-label' for='customCheck" + no_spaces + "'+>"
        + "</label>";
    */
    var cboxHTMLString = "<input type='checkbox'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>";


    var div = document.createElement('div');
    div.setAttribute("class", "custom-control custom-checkbox");
    var checkbox_div = createElementFromHTML(cboxHTMLString, div);


    var d_dict = {Select: checkbox_div};
    //iterate food_dict and add k,v to d_dict
    for(let key in food_dict) {
        var new_key = key;
        var new_val = food_dict[key];
        d_dict[new_key] = new_val;
    }
    //hint for extra url parameter
    var url_hint = "";
    //no rows yet
    if (num_rows === 0) {
        //add button at btm of div
        var table_div = document.getElementById('food-tbl-responsive');
        var addToMyTableBtn = document.createElement('button');
        addToMyTableBtn.setAttribute('id', 'addMyfoodBtn');
        addToMyTableBtn.setAttribute('type', 'submit');
        addToMyTableBtn.setAttribute('class', 'btn btn-primary');
        addToMyTableBtn.textContent = 'coming soon';
        insertAfter(addToMyTableBtn, table_div);//table_div.appendChild(addToMyTableBtn);

        //add another button
        //<a download="foods.csv" href="#" onclick="return ExcellentExport.csv(this, 'food-table');">Export to CSV</a>
        var downloadCsvBtn = document.createElement('a');
        downloadCsvBtn.setAttribute('class', 'food btn btn-secondary');
        downloadCsvBtn.setAttribute('download', 'foods.csv');
        downloadCsvBtn.setAttribute('href', '#');
        downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, 'food-table');");
        downloadCsvBtn.setAttribute('role', 'button');
        downloadCsvBtn.textContent = 'download csv';
        insertAfter(downloadCsvBtn, table_div);//table_div.appendChild(addToMyTableBtn);
        //button to delete rows
        var deleteCheckedBtn = document.createElement('button');
        deleteCheckedBtn.setAttribute('id', 'delCheckedBtnFood');
        deleteCheckedBtn.setAttribute('type', 'submit');
        deleteCheckedBtn.setAttribute('class', 'btn btn-danger');
        deleteCheckedBtn.textContent = 'delete selected';
        insertAfter(deleteCheckedBtn, table_div);
        //make new thead
        var thead = table.createTHead();
        var row = thead.insertRow(0);
        for (var h in d_dict){
            let cell = row.insertCell(-1);
            let newText = document.createTextNode(h);
            cell.appendChild(newText);
        }
        //var tbody = table.createTBody();
        var tbody = document.createElement('tbody');
        table.append(tbody);
        var row = tbody.insertRow(-1);

        for(let key in d_dict){
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
                //add eventListener???
            }
            else if(key==='Scientific Name'){
                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
            }
            else{
                let val = d_dict[key];
                let newText = document.createTextNode(val);
                cell.appendChild(newText);
            }
        }
        //add heading
        var table_heading = document.createElement('h3');
        var heading_text = document.createTextNode("Food Table");
        table_heading.appendChild(heading_text);

        table_div.insertBefore(table_heading, table_div.children[0] );
    }
    else{
        var tbodyRef = document.getElementById('food-table').getElementsByTagName('tbody')[0];
        var row = tbodyRef.insertRow(-1);
        for(let key in d_dict) {
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
            }
            else if(key==='food' || key=='Name'){
                if(key==='food'){
                    url_hint = "illness";
                }
                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
                cell.appendChild(gLink);
            }
            else {
                let newText = document.createTextNode(d_dict[key]);
                cell.appendChild(newText);
            }
        }
    }
};



/////////////////////////////////////////////////////////////////////////////
//new metabollite functions
//3. metabollite

$(document).ready(function(){
    $('#metabollite-btn').click(function(){
        showMetabollite();
    });
});

function showMetabollite() {

    //var metabollite = $("#metabollite-dropdown:selected").text();
    //var metabollite = $("#metabollite-dropdown:selected").val();
    var metabollite_dropdown = document.getElementById("metabollite-dropdown")
    var metabollite = metabollite_dropdown.options[metabollite_dropdown.selectedIndex].text;
    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'search-metabollite',
            search_term: metabollite
        },
        function (metabollite_json, status) {
            //json is a string
            var parsed = JSON.parse(metabollite_json);
            metabollite_dict = parsed[0];

            makeMetabolliteTable(metabollite_dict);

        }); //'json');
};

function makeMetabolliteTable(metabollite_dict){
    var checkbox_marker = 'metabollite';
    var table = document.getElementById('metabollite-table');
    var num_rows = table.rows.length;
    var metabollite_name = metabollite_dict['metabollite'];
    var no_spaces = metabollite_name.split(' ').join('');
    var check_name = `check-${no_spaces}`;
    //need to add key-value for check column header and check column value

    /*
    var cboxHTMLString = "<input type='checkbox' class='custom-control-input'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>"
        + "<label class='custom-control-label' for='customCheck" + no_spaces + "'+>"
        + "</label>";
    */
    var cboxHTMLString = "<input type='checkbox'"
        + "id='customCheck" + checkbox_marker + "' name='" + check_name + "'>";


    var div = document.createElement('div');
    div.setAttribute("class", "custom-control custom-checkbox");
    var checkbox_div = createElementFromHTML(cboxHTMLString, div);


    var d_dict = {Select: checkbox_div};
    //iterate metabollite_dict and add k,v to d_dict
    for(let key in metabollite_dict) {
        var new_key = key;
        var new_val = metabollite_dict[key];
        d_dict[new_key] = new_val;
    }
    //hint for extra url parameter
    var url_hint = "";
    //no rows yet
    if (num_rows === 0) {
        //add button at btm of div
        var table_div = document.getElementById('met-tbl-responsive');
        var addToMyTableBtn = document.createElement('button');
        addToMyTableBtn.setAttribute('id', 'addMymetabolliteBtn');
        addToMyTableBtn.setAttribute('type', 'submit');
        addToMyTableBtn.setAttribute('class', 'btn btn-primary');
        addToMyTableBtn.textContent = 'coming soon';
        insertAfter(addToMyTableBtn, table_div);//table_div.appendChild(addToMyTableBtn);

        //add another button
        //<a download="metabollites.csv" href="#" onclick="return ExcellentExport.csv(this, 'metabollite-table');">Export to CSV</a>
        var downloadCsvBtn = document.createElement('a');
        downloadCsvBtn.setAttribute('class', 'metabollite btn btn-secondary');
        downloadCsvBtn.setAttribute('download', 'metabollites.csv');
        downloadCsvBtn.setAttribute('href', '#');
        downloadCsvBtn.setAttribute('onclick', "return ExcellentExport.csv(this, 'metabollite-table');");
        downloadCsvBtn.setAttribute('role', 'button');
        downloadCsvBtn.textContent = 'download csv';
        insertAfter(downloadCsvBtn, table_div);//table_div.appendChild(addToMyTableBtn);
        //button to delete rows
        var deleteCheckedBtn = document.createElement('button');
        deleteCheckedBtn.setAttribute('id', 'delCheckedBtnMet');
        deleteCheckedBtn.setAttribute('type', 'submit');
        deleteCheckedBtn.setAttribute('class', 'btn btn-danger');
        deleteCheckedBtn.textContent = 'delete selected';
        insertAfter(deleteCheckedBtn, table_div);
        //make new thead
        var thead = table.createTHead();
        var row = thead.insertRow(0);
        for (var h in d_dict){
            let cell = row.insertCell(-1);
            let newText = document.createTextNode(h);
            cell.appendChild(newText);
        }
        //var tbody = table.createTBody();
        var tbody = document.createElement('tbody');
        table.append(tbody);
        var row = tbody.insertRow(-1);

        for(let key in d_dict){
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
                //add eventListener???
            }
            else if(key==='metabollite' || key==='Foods'){

                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
            }
            else{
                let val = d_dict[key];
                let newText = document.createTextNode(val);
                cell.appendChild(newText);
            }
        }
        //add heading
        var table_heading = document.createElement('h3');
        var heading_text = document.createTextNode("Metabollite Table");
        table_heading.appendChild(heading_text);

        table_div.insertBefore(table_heading, table_div.children[0] );
    }
    else{
        var tbodyRef = document.getElementById('metabollite-table').getElementsByTagName('tbody')[0];
        var row = tbodyRef.insertRow(-1);
        for(let key in d_dict) {
            let cell = row.insertCell(-1);
            if(key==='Select'){
                var checkbox_html = d_dict[key];
                cell.appendChild(checkbox_html);
            }
            else if(key==='metabollite' || key=='Name'){
                if(key==='metabollite'){
                    url_hint = "illness";
                }
                //make an "a" link element
                var disName = d_dict[key];
                var gLink = createLink(disName, url_hint);
                cell.appendChild(gLink);
                cell.appendChild(gLink);
            }
            else {
                let newText = document.createTextNode(d_dict[key]);
                cell.appendChild(newText);
            }
        }
    }
};




/////////////////////////////////////////////////////////////////////////////
//2. food (old)
/*
$(document).ready(function(){
    $('#food-btn').click(function(){
        showFood();
    });
});

function showFood(){

    //var food = $("#food-dropdown:selected").text();
    //var food = $("#food-dropdown:selected").val();
    var food_dropdown = document.getElementById("food-dropdown")
    var food = food_dropdown.options[food_dropdown.selectedIndex].text;
    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'search-food',
            search_term: food
        },
        function(food_json, status){
            //#search-results display table
            var parsed = JSON.parse(food_json);

            //////////////////////////////// to here
            //$('#test-out').append(food_obj);
            var table = $.makeTable(parsed);
            //$('#search-results').append(table);
        });

    //https://stackoverflow.com/a/27814032/13865853

    $.makeTable = function(food_obj){
        var table = document.getElementById('food-table');
        var num_rows = table.rows.length;
        //rows exist or not
        if (num_rows === 0) {
            //make new table
            var tblHeader = "<thead><tr>";
            for (var h in food_obj[0]) tblHeader += "<th>" + h + "</th>";
            tblHeader+= "</thead>";
            $(tblHeader).appendTo(table);

            //add tbody
            $.each(food_obj, function (index, value) {
                var tblRows = "<tbody><tr>";
                $.each(value, function (key, val) {
                    tblRows += "<td>" + val + "</td>";
                });
                tblRows += "</tr></tbody>";
                $(table).append(tblRows);
            });
            //num rows is 1
            return ($(table));
        }
        else {
            //get the tbody
            var $table_tbody = $('#food-table > tbody')
            var tblRows;
            $.each(food_obj, function (index, value) {
                tblRows = "<tr>";
                $.each(value, function (key, val) {
                    tblRows += "<td>" + val + "</td>";
                });
                tblRows += "</tr>";
            });
            $(tblRows).appendTo($table_tbody);
        }
    };
};
*/

/////////////////////////////////////////////////////////////////////////////////
//3. metabollite
/*
$(document).ready(function(){
    $('#metabollite-btn').click(function(){
        showMetabollite();
    });
});
function showMetabollite(){

    //var metabollite = $("#metabollite-dropdown:selected").text();
    //var metabollite = $("#metabollite-dropdown:selected").val();
    var metabollite_dropdown = document.getElementById("metabollite-dropdown")
    var metabollite = metabollite_dropdown.options[metabollite_dropdown.selectedIndex].text;
    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'search-metabollite',
            search_term: metabollite
        },
        function(metabollite_json, status){
            //#search-results display table
            var parsed = JSON.parse(metabollite_json);
            /////////////////////////////////to here
            var table = $.makeTable(parsed);
            //$('#search-results').append(table);
        });

    //https://stackoverflow.com/a/27814032/13865853

    $.makeTable = function(metabollite_obj){
        var table = document.getElementById('metabollite-table');
        var num_rows = table.rows.length;
        //rows exist or not
        if (num_rows === 0) {
            //make new table
            var tblHeader = "<thead><tr>";
            for (var h in metabollite_obj[0]) tblHeader += "<th>" + h + "</th>";
            tblHeader+= "</thead>";
            $(tblHeader).appendTo(table);

            //add tbody
            $.each(metabollite_obj, function (index, value) {
                var tblRows = "<tbody><tr>";
                $.each(value, function (key, val) {
                    tblRows += "<td>" + val + "</td>";
                });
                tblRows += "</tr></tbody>";
                $(table).append(tblRows);
            });
            //num rows is 1
            return ($(table));
        }
        else {
            //get the tbody
            var $table_tbody = $('#metabollite-table > tbody')
            var tblRows;
            $.each(metabollite_obj, function (index, value) {
                tblRows = "<tr>";
                $.each(value, function (key, val) {
                    tblRows += "<td>" + val + "</td>";
                });
                tblRows += "</tr>";
            });
            $(tblRows).appendTo($table_tbody);
        }
    };
};

*/
////////////////////////////////////////////////////////////////////////

//hide modal on cancel button with jquery
//https://www.tutorialrepublic.com/faq/how-to-close-a-bootstrap-modal-window-using-jquery.php
$(document).ready(function(){
    $("#cancel-ask-button").click(function(){
        $("#modal-ask").modal('hide');
    });
    $("#cancel-search-button").click(function(){
        $("#modal-search").modal('hide');
    });

});

///////////////////////////////////////////////////////////////////
//delete account
//get SESSION vars and delete from SQL
document.getElementById('btn-delete-account')
    .addEventListener('click', function() {
        var controller = 'controller.php'

        $.post(controller, //url, data, callback, dataype=Json
            {
                username: 'User',
                page: 'SpaPage',
                command: 'delete-account',
            },
            function (deletion_json, status) {
                //json is an arrary of objects/dicts
                var parsed = JSON.parse(deletion_json);

                var res_msg = parsed['deleted'];
                var deleted_msg = document.createTextNode(res_msg);
                document.getElementById('acct-delete-msg').appendChild(deleted_msg);
                if (res_msg === 'account deleted') {
                    //sign out
                    //var signout_form = document.getElementById('Sign-Out');
                    //signout_form.submit();
                    $('#Sign-Out').submit();
                }

            });
    });



/////////////////////////////////////////////////////////////////////////
//at top of page
//function update_profile_ajax() {
document.getElementById('btn-edit-profile').addEventListener('click', function () {
    var new_username = "";
    var new_password = "";
    var new_email = "";

    new_username = document.getElementById('new-username').value;
    new_password = document.getElementById('new-password').value;
    new_email = document.getElementById('new-email').value;

    //insert updated profile to div
    var updated = document.getElementById('updated-profile');


    var controller = 'controller.php';
    $.post(controller, //url, data, callback, dataype=Json
        {
            username: 'User',
            page: 'SpaPage',
            command: 'edit-profile-deux',
            newUsername: new_username,
            newPassword: new_password,
            newEmail: new_email
        },
        function (profile_json, status) {
            //json is an arrary of objects/dicts
            var parsed = JSON.parse(profile_json);
            //var profile_obj = parsed;
            //shoudl return for successful mysql insertion

            var newName = parsed['name'];
            var newPassword = parsed['password'];
            var newEmail = parsed['email'];

            var newProfile = document.createTextNode(
                "Username: " + newName
                + " Password: " + newPassword
                + " Email: " + newEmail)
            updated.appendChild(newProfile);


        });
});

//////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////
//not really used
//hide default msg on button click
document.getElementById("submit-ask").addEventListener('click', function(){
    document.getElementById("default-msg").style.display = "none";
})
document.getElementById("submit-search").addEventListener('click', function(){
    document.getElementById("default-msg").style.display = "none";
})
/*
var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status==200){
                //post message and sign out if success
                var deletion_res = this.responseText;
                var res = deletion_res['deleted'];
                var deleted_msg = document.createTextNode(res);
                document.getElementById('account-delete-msg').appendChild(deleted_msg);
                if(res==='account deleted'){
                    //sign out
                    //var signout_form = document.getElementById('Sign-Out');
                    //signout_form.submit();
                    //jQuery
                    $('#Sign-Out').submit();
                }
            }
        };
        var controller = 'controller.php'
        var json_send = JSON.stringify({page: "SpaPage", command: "deleteAccount"});

        xhttp.open("POST", controller, true);

        //set $_POST var
        xhttp.send(json_send);

    });

 */
