<!--author: Nobu Kim
citations: https://stackoverflow.com/a/64562747/13865853
-->

<html lang="en_us">
<head>
    <!--google siginin-->
    <meta name="google-signin-client_id" content="319069922926-ol62i59nva0evssmp9fr7m824r75kd32.apps.googleusercontent.com">
    <title>Bioactive Compounds</title>
    <script src="js/jquery-3.5.1.js"></script>
    <link href="css/startpage.css" rel="stylesheet">
    <!--google signin-->
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

</head>

<body>
<?php
//if coming from MainPage clicking SignOUt, clear Session and other variables
if(isset($_POST['page']) && isset($_POST['command'])){
    if(($_POST['page']=='SpaPage') && $_POST['command']=='SignOut'){
        //destroy session
        unset($_SESSION);
        session_destroy();
        session_write_close();
        $_POST = array();
        $_REQUEST = array();
        //exit();
    }
}

?>
    <div id='pane-title'>
        <h1 style='text-align:center'>Bioactive Compounds in Food</h1>
        <h3 style='text-align:center'>Prevention and Treatment of Disease</h3>
        <hr>

        <!-- menu -->
        <ul id='ddm'>
            <li style='width: 50px;'><img src='menu_icon.png' width='50px' height='50px'></img>
                <ul style='width:80px'>
                    <li id='menu-signin'>Sign In</li>
                    <li id='menu-join'>Join</li>
                </ul>
            </li>
        </ul>
    </div>

    <div id='pane-content'>
        <!-- blanket for modal windows -->
        <div id='blanket'>
        </div>

        <h2>The Next Level in Healthy Eating</h2>

        <!-- SignIn modal window-->
        <div id='signin-box' class='modal-window'>
            <h2 style='text-align:center'>Sign In</h2>
            <br>
            <form method='post' action='controller.php'>
                <input type='hidden' name='page' value='StartPage'>
                <input type='hidden' name='command' value='SignIn'>
                <label class='modal-label'>Username:</label>
                <input type='text' name='username' required>
                <span id="username-error">
                    <?php
                    if(isset($_SESSION['display_type'])){
                        if($_SESSION['display_type']== 'signin') {
                            if(isset($_SESSION['error_msg_username'])){
                                $username_error = $_SESSION['error_msg_username'];
                                echo $username_error;
                            }
                        }
                    }?>
                </span>
                <br>
                <br>
                <label class='modal-label'>Password:</label>
                <input type='password' name='password' required>
                <span id="password-error">
                    <?php
                    if(isset($_SESSION['display_type'])){
                        if($_SESSION['display_type']== 'signin') {
                            if (isset($_SESSION['error_msg_password'])) {
                                $password_error = $_SESSION['error_msg_password'];
                                echo $password_error;
                            }
                        }
                    }?>

                </span>
                <br>
                <br>
                <div class="button-container">
                    <input type='submit' value='Sign In'>&nbsp;&nbsp;
                    <input id='cancel-signin-button' type='button' value='Cancel'>&nbsp;&nbsp;
                    <input type='reset' value='Reset'>
                </div>
            </form>
            <!--<div class="g-signin2" data-onsuccess="onSignIn"></div>-->

        </div>

        <!-- Join modal window-->
        <div id='join-box' class='modal-window'>
            <h2 style='text-align:center'>Join</h2>
            <br>
            <form method='post' action='controller.php'>
                <input type='hidden' name='page' value='StartPage'>
                <input type='hidden' name='command' value='Join'>
                <label class='modal-label'>Username:</label>
                <input type='text' name='username' required>
                <span id="username-error">
                    <?php
                    if(isset($_SESSION['display_type'])){
                        if($_SESSION['display_type']== 'join') {
                            if(isset($_SESSION['error_msg_username'])){
                                $username_error = $_SESSION['error_msg_username'];
                                echo $username_error;
                            }
                        }
                    }?>

                </span>
                <br>
                <br>
                <label class='modal-label'>Password:</label>
                <input type='password' name='password' required>
                <span id="password-error">
                    <?php
                    if(isset($_SESSION['display_type'])){
                        if($_SESSION['display_type']== 'join') {
                            if (isset($_SESSION['error_msg_password'])) {
                                $password_error = $_SESSION['error_msg_password'];
                                echo $password_error;
                            }
                        }
                    }?>
                </span>

                <br>
                <br>
                <label class='modal-label'>Email:</label>
                <input type='text' name='email' required>
                <span id="email-invalid">
                    <?php
                    if(isset($_SESSION['display_type'])){
                        if($_SESSION['display_type']== 'join') {
                            if (isset($_SESSION['error_msg_email'])) {
                                $email_error = $_SESSION['error_msg_email'];
                                echo $email_error;
                            }
                        }
                    }?>
                </span>
                <br>
                <br>
                <div class="button-container">
                    <input type='submit' value='Submit Query'>&nbsp;&nbsp;
                    <input id='cancel-join-button' type='button' value='Cancel'>&nbsp;&nbsp;
                    <input type='reset' value='Reset'>
                </div>
            </form>
            <?php
                //if any error messages are set, unset session so user starts over
                /*if(isset($_SESSION['error_msg_username']) || isset($_SESSION['error_msg_password'])
                    || isset($_SESSION['error_msg_email'])){
                    unset($_SESSION);
                    session_destroy();
                    session_write_close();
                    //header('Location: startpage.php');
                    //die;
                }*/
            ?>
        </div>
    </div>
<script>
    window.addEventListener('load', function(){
        <?php
        if(isset($_SESSION['display_type'])) {
            $d_type = $_SESSION['display_type'];
            //echo "$d_type";
            if ($d_type != 'none') {
                if ($d_type == 'join') {
                    echo 'show_join()';
                }
                else if ($d_type == 'signin') {
                    echo 'show_signin()';
                }
                else if($d_type=='success'){
                    echo 'hide_modals()';
                }
            }
            else{//dtype=none
                echo 'hide_modals()';
            }
        }
        ?>
    });
</script>
<!--
<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        //window.location.replace('http://localhost/project/spa.php');

        //call an ajax post request with profile.getName()
        //set session['valid_user']
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
    }

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
</script>
-->
<script src="js/googleSignin.js"></script>
<script src="js/startpage.js"></script>

</body>
</html>
