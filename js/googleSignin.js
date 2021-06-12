function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    //call an ajax post request with profile.getName()
    //set session['valid_user']

    var controller = 'controller.php';
    $.post(controller,
        {
            page: 'StartPage',
            command: 'SignIn',
            username: 'googleUser',
            password: 'Tennis33!'
        },
        function(data, status){
            //var data_obj = data[0];
            //var dataObj = JSON.parse(data);
            var gUser = data['dad'];
            console.log('data: ' + gUser + ' status: ' + status );
            //window.location.replace('http://localhost/project/spa.php');
        }, 'json');



}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();

    auth2.signOut().then(function () {
        console.log('User signed out.');
        auth2.disconnect();
    });
}
//load gapi.auth2 library
function onLoad(){
    gapi.load('auth2', function(){
        gapi.auth2.init();
    });
}
/*
var controller = 'controller.php';
$.post(controller,
    {
       page: 'SpaPage',
       command: 'SignOut',
        signoutType: 'google',
    },
    function(data, status){
        var received = data[0];
        var gSignOut = received['type'];

        console.log(gSignOut + " signout status is " + status);
    }, 'json');

///window.location.replace('http://localhost/project/startpage.php');
*/
/*
var validUser = {
        command: 'SignIn',
        username: 'googleUser',
        password: 'password'
    };
    var username = profile.getName();
    var controller = 'controller.php';
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            console.log(xmlHttp.responseText);
        }
    }
    var myJson = JSON.stringify(validUser);
    xmlHttp.open('post', controller, 'true');
    xmlHttp.send(myJson);
 */
