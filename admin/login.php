<?php
require_once("../config/connect.php");
$errorMsg = [];
$login = false;
if (isset($_POST['login'])) {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errorMsg['email'] = "Please Enter a Email...!";
    }
    if (empty($password)) {
        $errorMsg['password'] = "Please Enter a password...!";
    }

    if (count($errorMsg) <= 0) {
        $selectSql = "SELECT * FROM users WHERE userEmail = '$email' AND userPassword = '$password'";
        $result = mysqli_query($conn, $selectSql);
        $data = mysqli_fetch_assoc($result);


        if ($data['userEmail'] == $email && $data['userPassword'] == $password) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['userName'] = $data['userName'];
            $_SESSION['userEmail'] = $data['userEmail'];
            $_SESSION['userID'] = $data['userID'];
            header("location: ./");
        } else {
            echo "<script>alert('Login Falid')</script>";
        }
    }
}


?>


<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN | Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="wrapper-admin" class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <img class="logo" src="images/news.jpg">
                    <h3 class="heading">Admin</h3>
                    <!-- Form Start -->
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" class="form-control" placeholder="">
                            <?php if (isset($errorMsg['email'])) : ?>
                                <span style="color: red;"><?php echo $errorMsg['email'];  ?></span>
                            <?php endif ?>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="">
                            <?php if (isset($errorMsg['password'])) : ?>
                                <span style="color: red;"><?php echo $errorMsg['password'];  ?></span>
                            <?php endif ?>
                        </div>
                        <input type="submit" name="login" class="btn btn-primary" value="login" />
                    </form>
                    <!-- /Form  End -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>