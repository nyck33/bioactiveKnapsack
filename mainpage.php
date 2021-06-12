<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to_fit=no">
    <title>Bioactive Compounds</title>
    <!-- boostrap comes first -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .top-buffer{
            margin-top: 50px;
        }
        .btn{
            border: 2px solid black;
            background-color: white;
            color: black;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
        }
        .row-modal{
            border: 1px gray;
        }
        #searchbox{
            width:80%;
        }
        .right {
            float: right;
            width: 35%;
            padding: 20px;
        }

    </style>
</head>
<body>
<!--navbar-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Expand at md</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search">
        </form>
    </div>
</nav>


    <div class="container">
        <div class="row" id="title-pane">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?php
                $valid_user = $_SESSION['valid_user'];
                echo "<div style='text-align:center'>
                        <h1>TRU Questions and Answers<h1>
                        <h3>- User: $valid_user -</h3><br>
                        </div>";
                ?>
            </div>
        </div>
        <div class="row justify-content-start border" id="nav-pane">

            <div class="col-lg-3 col-md-3 col-sm-3 mt-3 mb-3" id="but-choices">
                <button type="button" id="btn-ask" class="btn btn_primary" data-toggle="modal"
                        data-target="#modal-ask">
                    Post disease
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 mt-3 mb-3" style="text-align: center">
                <button type="button" id="btn-search" class="btn btn_primary" data-toggle="modal"
                        data-target="#modal-search" value="Search Questions">
                    Search foods
                </button>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 mt-3 mb-3" style="text-align: center">
                <!--todo: use jquery for signout-->
                <form id="Sign-Out" action="controller.php" style="display: none">
                    <input type='hidden' name='page' value='MainPage'>
                    <input type='hidden' name='command' value='SignOut'>
                    <!--
                    <input type="button" id="btn-signout" class="btn btn_primary" value="Sign Out">
                    -->
                </form>
                <button id="btn-signout" class="btn btn_primary">Sign Out</button>
            </div>
        </div>
        <div class="row top-buffer" id="res-pane">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!--default message-->
                <?php
                //check if matches or q-ask-success are set
                if(!isset($_SESSION['matches_arr']) && (!isset($_SESSION['q-ask-success']))){
                    echo "<div style='text-align: center'>
                        <h2>Results will be displayed here</h2>
                        </div>";
                }
                ?>
                <!--success message-->
                <?php
                if(isset($_SESSION['q-ask-success'])){
                    if($_SESSION['q-ask-success']==true) {
                        echo "<p>Posted successfully!<p>";
                    }
                    //todo: hide default msg here I think
                    unset($_SESSION['q-ask-success']);
                }
                ?>

                <!--table-->
                <?php
                $matches_arr = [];
                if(isset($_SESSION['matches_arr'])){
                    $matches_arr = $_SESSION['matches_arr'];
                }
                if(count($matches_arr) > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                            <?php echo implode('</th><th>',
                                array_keys(current($matches_arr))); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($matches_arr as $row): array_map('htmlentities',
                        $row); ?>
                        <tr>
                            <td><?php echo implode('</td><td>', $row); ?></td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                </table>
                    <!--unset only if set-->
                    <?php unset($_SESSION['matches_arr']); ?>
                <?php endif;?>
            </div>
        </div>
    </div>

    <?php
        //if(!isset($_SESSION['']))
    ?>
    <script>
        //sign out form submit
        $(document).ready(function(){
            $('#btn-signout').click(function(){
                $('#Sign-Out').submit();
            });
        });
    </script>
    <script>
        /*
        //jquery for btn-signout
        $(document).ready(function(){
            $("#btn-signout").click(function(){
                <?//php $_POST['command'] = 'SignOut'; ?>
                window.location.href= "http://cs.tru.ca/~nkimf20/sem7new/controller.php"
                //window.location.href= "http://localhost/sem7new/controller.php";
            });
        });
        */
    </script>
    <script>
        //hide default msg on button click
        document.getElementById("submit-ask").addEventListener('click', function(){
            document.getElementById("default-msg").style.display = "none";
        })
        document.getElementById("submit-search").addEventListener('click', function(){
            document.getElementById("default-msg").style.display = "none";
        })
    </script>

    <script>
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
    </script>

    <!--for bs to work
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    -->
</body>
</html>
