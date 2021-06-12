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
    <!--google signin-->
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<!--php require login-->

<?php
/*
if(!isset($_SESSION['valid_user'])){
    $_POST['page'] = 'SpaPage';
    $_POST['command'] = 'SignOut';
    include('controller.php');
    die();
}
*/
?>
<body class="content">
<!--fb JS SDK-->
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
            <button id="btn-signout" class="btn btn_primary" style="color:white">Sign Out</button>
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
                            <span data-feather="file"></span>
                            Edit User Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="shopping-cart"></span>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="users"></span>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations
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
        <!--main content top space under nav bar-->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <!--user profile section-->
    <div class="container">
        <div class="row" id="user-profile">
            <div class="col-md-6">
                <p>
                    Leave blank if not changing.  After entering items to change press submit.
                </p>
                <label>current username:</label>
                <p id="current-username">
                <?php
                echo $_SESSION['username'];
                ?>
                </p>
                <br>
                <label>current password:</label>
                <p id="current-password">
                <?php
                echo $_SESSION['password'];
                ?>
                </p>
                <br>
                <label>current email:</label>
                <p id="current-email">
                <?php
                echo $_SESSION['email'];
                ?>
                </p>
                <br>
                <form method="post" action="controller.php">
                    <input type="hidden" name="page" value="SpaPage">
                    <input type="hidden" name="command" value="change-profile">
                    <label>new username:</label>
                    <input type="text" class="profile-input" name="new-username">
                    <br>
                    <label>new password</label>
                    <input type="text" class="profile-input" name="new-password">
                    <br>
                    <label>new email</label>
                    <input type="text" class="profile-input" name="new-email">
                    <br>
                    <div class="right">
                        <input type='submit' id='submit-new-username' value="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
