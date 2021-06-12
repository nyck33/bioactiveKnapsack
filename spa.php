<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <!--google siginin-->
    <meta name="google-signin-client_id" content="319069922926-ol62i59nva0evssmp9fr7m824r75kd32.apps.googleusercontent.com">
    <!--facebook share-->
    <meta property="og:url"           content="http://localhost/project/spa.php" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Bioactive Compounds" />
    <meta property="og:description"   content="Your description" />
    <meta property="og:image"         content="http://localhost/project/leoHealth.jpg" />
    <title>Bioactive Compounds</title>
    <!-- boostrap comes first -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--mark.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js"></script>
    <script src="js/mark.min.js" ></script>
    <!-- csv excellentexport-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
    <!--google signin-->
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<!--php require login-->
<?php
if(!isset($_SESSION['valid_user'])){
    $_POST['page'] = 'SpaPage';
    $_POST['command'] = 'SignOut';
    include('controller.php');
    die();
}
?>
<body class="content">
<!--fb JS SDK-->

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0" nonce="PkmHuPh0"></script>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!---------------------------------------------------------------------->
<!---------------------------------------------------------------------->

<?php
require_once('dropdown_options_arr.php');
?>
<!--navbar top-->
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Bioactive Compounds</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-50 searchbar" type="text" name="keyword" placeholder="Search terms on page" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form id="Sign-Out" action="controller.php" style="display: none">
                <input type='hidden' name='page' value='SpaPage'>
                <input type='hidden' name='command' value='SignOut'>
            </form>
            <input type="submit" form="Sign-Out" value="Sign Out">
        </li>
    </ul>
</nav>



<!--sidebar left-->
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="shopping-cart"></span>
                            Products coming soon
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="users"></span>
                            Customers coming soon
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Reports coming soon
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations coming soon
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li>
                    <li class="share-btn">
                        <div class="fb-share-button" data-href="http://localhost/project/spa.php"
                             data-layout="button_count" data-size="small">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%2Fproject%2Fspa.php&amp;src=sdkpreparse"
                               class="fb-xfbml-parse-ignore">
                                <span data-feather="file-text">
                                    Share</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div><!--end row-->
</div><!--end container-->
<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->


<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->

<!--for mark.js-->
<div class="panel panel-default"><div class="panel-body context">
    <!--chart goes here-->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
    <!--user profile section-->
    <div class="container">
        <div class="row" id="user-profile">
            <div class="col-md-6">
                <H3>User Profile</H3>
                <p>
                    Only fill the boxes to change.  Press "Edit Profile" with all 3 empty to see current profile.
                </p>
                <!--<form onsubmit="update_profile_ajax()">-->
                <label>change username:</label>
                <input type="text" id="new-username" placeholder="username">
                <br>
                <label>change password:</label>
                <input type="text" id="new-password" placeholder="password">
                <br>
                <label>change email:</label>
                <input type="text" id="new-email" placeholder="email">
                <br>
                <button id="btn-edit-profile" class="btn btn-warning">Edit Profile</button>
                <br>
                <button id="btn-delete-account" class="btn btn-danger">Delete Account</button>
            </div>
            <div class="col-md-6">
                <div id="updated-profile">
                    Profile Info here
                </div>
                <div id="acct-delete-msg">
                    Delete message here but sign out so can't see
                </div>

            </div>
        </div>
    </div>
    <hr>
            <!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
<!--dropdowns-->

    <div class="container">
        <div class="row" id="container-title">
            <h3>Use Dropdowns to select term and click submit</h3>
        <div class="row" id="search-boxes">
            <div class="col-lg-6 col-md-6">
                <?php
                $disease_options_arr = [];
                if(!isset($_SESSION['disease-options-arr'])){
                    $disease_options_arr = get_disease_options();
                }
                else{
                    $disease_options_arr = get_disease_options();
                }
                for($i=0; $i<count($disease_options_arr); $i+=1){
                    //echo "{$disease_options_arr[$i]}";
                }
                ?>
                <form action="">
                    <label class="dropdown-label">Choose Disease:</label>
                    <br>
                    <select id='disease-dropdown' name="disease-option" >
                        <?php
                        $disease_options_arr = array();
                        if(!isset($_SESSION['disease-options-arr'])){
                            $disease_options_arr = get_disease_options();
                        }
                        else{
                            $disease_options_arr = $_SESSION['disease-options-arr'];
                        }
                        //$disease_options_arr = array_unique($disease_options_arr);
                        //sort($disease_options_arr);
                        foreach($disease_options_arr as $disease){
                            echo "<option value='". $disease ."'>" . $disease . "</option>";
                        }
                        ?>
                        <option selected="selected">
                            <?php echo "$disease_options_arr[0]";?>
                        </option>
                    </select>
                </form>
                <br>
                <button id="disease-btn" class="btn btn-primary">Submit Disease</button>
            </div>
            <div class="col-lg-6 col-md-6">
                <div id="array-test">
                    <?php
                    $food_options_arr = [];
                    if(!isset($_SESSION['food-options-arr'])){
                        $food_options_arr = get_food_options();
                    }
                    else{
                        $food_options_arr = get_food_options();
                    }
                    for($i=0; $i<count($food_options_arr); $i+=1){
                        //echo "{$food_options_arr[$i]}";
                    }
                    ?>
                </div>
                <form action="">
                    <label class="dropdown-label">Choose Food:</label>
                    <br>
                    <select id="food-dropdown" name="food-option">
                        <?php
                        $food_options_arr = array();
                        if(!isset($_SESSION['food-options-arr'])){
                            $food_options_arr = get_food_options();
                        }
                        else{
                            $food_options_arr = $_SESSION['food-options-arr'];
                        }
                        //$food_options_arr = array_unique($food_options_arr);
                        //sort($food_options_arr);
                        foreach($food_options_arr as $food){
                            echo "<option value='". $food ."'>" . $food . "</option>";
                        }
                        ?>

                        <option selected="selected">
                            <?php echo "$food_options_arr[0]";?>
                        </option>
                    </select>
                </form>
                <br>
                <button id="food-btn" class="btn btn-primary">Submit Food</button>
            </div>
            <div class="col-lg-6 col-md-6">
                <div id="array-test2">
                    <?php
                    $metabollite_options_arr = [];
                    if(!isset($_SESSION['food-options-arr'])){
                        $metabollite_options_arr = get_metabollite_options();
                    }
                    else{
                        $metabollite_options_arr = get_metabollite_options();
                    }
                    for($i=0; $i<count($metabollite_options_arr); $i+=1){
                        //echo "{$metabollite_options_arr[$i]}";
                    }
                    ?>
                </div>
                <form action="">
                    <label class="dropdown-label">Choose Bioactive Compound:</label>
                    <br>
                    <select id="metabollite-dropdown" name="metabollite-option">
                        <?php
                        $metabollite_options_arr = [];
                        if(!isset($_SESSION['metabollite-options-arr'])){
                            $metabollite_options_arr = get_metabollite_options();
                        }
                        else {
                            $metabollite_options_arr = $_SESSION['metabollite-options-arr'];
                        }
                        //$metabollites_options_arr = array_unique($metabollite_options_arr);
                        //sort($metabollite_options_arr);
                        foreach($metabollite_options_arr as $sci_name){
                            $trim_name = trim($sci_name, "[]?");
                            str_replace("/", " ", $trim_name);
                            if($trim_name != ""){
                                echo "<option value={strtolower($trim_name)}>$trim_name</option>";
                            }
                        }
                        ?>
                        <option selected="selected">
                            <?php echo "$metabollite_options_arr[0]";?>
                        </option>
                    </select>
                </form>
                <br>
                <button id="metabollite-btn" class="btn btn-primary">Submit Metabollite</button>
            </div>
        </div><!--end row of search boxes-->
    </div>
    <br>
    <div class="container">
        <div class="row" id="output-tables">
            <div class="col-md-12">
                <div id="search-results">
                    <p>Result Tables Here</p>
                    <div id="dis-tbl-responsive" class="table-responsive">
                        <table id="disease-table" class="table table-hover"></table>
                    </div>

                    <br>

                    <!--
                    <a download="diseases.csv" href="#" onclick="return ExcellentExport.csv(this, 'disease-table');">Export to CSV</a>
                    -->
                    <br>
                    <div id="food-tbl-responsive" class="table-responsive">
                        <table id="food-table" class="table table-hover"></table>
                    </div>

                    <br>
                    <br>
                    <div id="met-tbl-responsive" class="table-responsive">
                        <table id="metabollite-table" class="table table-hover"></table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

<hr>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <H3>Search Database for key term</H3>
                <input type="text" id="input-key-term"
                       style="width:50%" placeholder="enter key term">
                <br>
                <button id="btn-key-term" class="btn btn-primary">Search Term</button>
                <p>Show results here</p>
                <div id="db-search-result">
                    <!--tables in here, each with buttons and own enclosing divs-->
                </div>
            </div>
        </div>
    </div>
<!------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------>


    <!--end modals-->
</main>
        <!--for mark.js-->
    </div></div>

<script>
    //todo: check with external googleSignin.js
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        window.location.replace('http://localhost/project/spa.php');
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
<script src="js/googleSignin.js"></script>
<script src="js/dashboard.js"></script>
<script src="js/spa_jquery.js"></script>
<script src="js/spa.js"></script>
<script src="js/deleteCheckedRows.js"></script>
<script src="js/checkboxToMyTable.js"></script>
<script src="js/searchKeyTerm.js"></script>
<!--excellentexport-->
<script src="http://requirejs.org/docs/release/2.3.6/minified/require.js"></script>
<script>
    require(['dist/excellentexport'], function(ee) {
        window.ExcellentExport = ee;
    });
</script>

<script src="js/navbarSearch.js"></script>
<script src="js/main.js"></script>
</body>
</html>


