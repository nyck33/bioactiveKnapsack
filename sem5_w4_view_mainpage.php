<html lang="en-us">
<body>
<input type='hidden' name='page' value='MainPage'>
<?php
    $valid_user = $_SESSION['valid_user'];
    $user_id = $_SESSION['user_id'];
    echo "<div style='text-align:center'>
        <h1>TRU Questions and Answers<h1><br>
        <h3>Fall 2020</h3><br>
        <p>User: $valid_user</p>
        <p>User ID: $user_id</p>
        </div>";
    $_POST = array();
    $_SESSION = array();
    $_REQUEST = array();
    ?>
</body>
</html>
