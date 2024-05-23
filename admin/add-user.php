<?php include "header.php"; ?>
<?php
$errorMsg = [];
require_once("../config/connect.php");
if (isset($_POST['userData'])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $userName = test_input($_POST['userName']);
    $userEmail = test_input($_POST['userEmail']);
    $userPassword = test_input($_POST['userPassword']);
    $userConfirmPassword = test_input($_POST['userConfirmPassword']);
    $userRole = test_input($_POST['userRole']);
    $userStatus = test_input($_POST['userStatus']);
    $userJoinDate = test_input($_POST['userJoinDate']);
    // print_r($_FILES);

    // echo $userStatus;

    if (empty($userName)) {
        $errorMsg['userName'] = "Please Enter a Full Name...!";
    }
    if (empty($userEmail)) {
        $errorMsg['userEmail'] = "Please Enter a Email...!";
    }
    if (empty($userPassword)) {
        $errorMsg['userPassword'] = "Please Enter a Password...!";
    }
    if($userRole < 0) {
        $errorMsg['userRole'] = "Please Select User Role...!";
    }
    if($userStatus < 0) {
        $errorMsg['userStatus'] = "Please Select User Status...!";
    }
    if (empty($userConfirmPassword)) {
        $errorMsg['userConfirmPassword'] = "Please Enter a Confirm Password...!";
    }
    if (empty($userJoinDate)) {
        $errorMsg['userJoinDate'] = "Please Enter a User Join Date...!";
    }

    if($userPassword == $userConfirmPassword) {
        if(count($errorMsg) <= 0) {
            $userImage = null;
            $userCreateDate = date("Y-m-d H:i:s");
            // $hash = password_hash($userPassword, PASSWORD_DEFAULT);

            if(!empty($_FILES['userImage']['name'])) {
                $userImage = "User_News_" . time() . "_" . str_replace(" ", "_", $userName) . "_" . str_replace(" ", "_", $_FILES['userImage']['name']);
                move_uploaded_file($_FILES['userImage']['tmp_name'], "upload/" . $userImage);
            }

            $insertSql = "INSERT INTO users (userName, userEmail, userPassword, userRole, userStatus, userImage, userJoinDate, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $userName, $userEmail, $userPassword, $userRole, $userStatus, $userImage, $userJoinDate, $userCreateDate);

            if(mysqli_stmt_execute($stmt)) {
                echo "<script>alert('User Account Create Successfully'); </script>";
                
            } else {
                echo "<script>alert('Technical Problem: Account Not Create')</script>";
            }
        }

    } else {
        echo "<script>alert('Password Not Match !')</script>";
    }
}
unset($_POST['userData']);


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="userName">Full Name:</label>
                        <input type="text" name="userName" class="form-control" placeholder="Full Name...">
                        <?php if (isset($errorMsg['userName'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userName'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email:</label>
                        <input type="email" name="userEmail" class="form-control" placeholder="email...">
                        <?php if (isset($errorMsg['userEmail'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userEmail'];  ?> </span>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="userPassword">Password:</label>
                        <input type="password" name="userPassword" class="form-control" placeholder="Password...">
                        <?php if (isset($errorMsg['userPassword'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userPassword'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="userConfirmPassword">Comfirm Password:</label>
                        <input type="password" name="userConfirmPassword" class="form-control" placeholder="Confirm Password...">
                        <?php if (isset($errorMsg['userConfirmPassword'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userConfirmPassword'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="userRole">User Role:</label>
                        <select class="form-control" name="userRole">
                            <option value="">Select</option>
                            <option value="admin">Admin</option>
                            <option value="repoter">Repoter</option>
                        </select>
                        <?php if (isset($errorMsg['userRole'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userRole'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="userStatus">User Status:</label>
                        <select class="form-control" name="userStatus">
                            <option value="">Select</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <?php if (isset($errorMsg['userStatus'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userStatus'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="userImage">User Photo</label>
                        <input type="file" name="userImage" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="userJoinDate">Joing Date</label>
                        <input type="date" name="userJoinDate" class="form-control">
                        <?php if (isset($errorMsg['userJoinDate'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['userJoinDate'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <input type="submit" name="userData" class="btn btn-primary" value="Save" />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>


<?php include "footer.php"; ?>