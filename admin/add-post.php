<?php include "header.php"; ?>
<?php
session_start();
$userEmail = $_SESSION['userEmail'];
require_once("../config/connect.php");
$errorMsg = [];

// print_r($_SESSION);

$userID = $_SESSION['userID'];

$selectUserSql = "SELECT userID, userName FROM users WHERE '$userID'";
$selectUserResult = mysqli_query($conn, $selectUserSql);
$users = mysqli_fetch_all($selectUserResult, MYSQLI_ASSOC);

// print_r($users);



$selectSql = "SELECT categoryID, categoryName FROM news_categories";
$categoryResult = mysqli_query($conn, $selectSql);
$categorys = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

if (isset($_POST['postSubmit'])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $postAuthor = test_input($_POST['postAuthor']);
    $postTitle = test_input($_POST['postTitle']);
    $postDate = test_input($_POST['postDate']);
    $postCategory = test_input($_POST['postCategory']);
    $postSummary = test_input($_POST['postSummary']);
    $postDescription = test_input($_POST['postDescription']);
    $postImage = test_input($_FILES['postImage']['name']);
    $postStatus = test_input($_POST['postStatus']);

    if (empty($postAuthor)) {
        $errorMsg['postAuthor'] = "Please Select  News Author...!";
    }
    if (empty($postTitle)) {
        $errorMsg['postTitle'] = "Please Enter a News Title...!";
    }
    if (empty($postDate)) {
        $errorMsg['postDate'] = "Please Enter a News Date...!";
    }
    if (empty($postCategory)) {
        $errorMsg['postCategory'] = "Please Select a News Category...!";
    }
    if (empty($postSummary)) {
        $errorMsg['postSummary'] = "Please Enter a News Summary...!";
    }
    if (empty($postDescription)) {
        $errorMsg['postDescription'] = "Please Enter a News Description...!";
    }
    if (empty($postImage)) {
        $errorMsg['postImage'] = "Please Select News Image...!";
    }
    if (empty($postStatus)) {
        $errorMsg['postStatus'] = "Please Select a News Status...!";
    }

    if (count($errorMsg) <= 0) {
        $postCreateDate = date("Y-m-d H:i:s");
        if (!empty($postImage)) {
            $postImage = "User_News_" . time() . "_" .  str_replace(" ", "_", $_FILES['postImage']['name']);
            move_uploaded_file($_FILES['postImage']['tmp_name'], "upload/post" . $postImage);
        }
        $insertSql = "INSERT INTO posts (newsAuthor, newsTitle, newsSummary, newsDescription, newsImage, newsCategory, newsDate, newsStatus, createAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "sssssssss", $postAuthor, $postTitle, $postSummary, $postDescription, $postImage, $postCategory, $postDate, $postStatus, $postCreateDate);

            if(mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Post Create Successfully'); </script>";
                
            } else {
                echo "<script>alert('Technical Problem: Post Not Create')</script>";
            }

    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="postAuthor">News Author:</label>
                        <select name="postAuthor" class="form-control">
                            <option value=""> Select Category</option>
                            <?php foreach ($users as $user) :  ?>
                                <option value="<?php $user['userID']; ?>"> <?php echo $user['userName']; ?></option>
                            <?php endforeach ?>
                            <?php if (isset($errorMsg['postAuthor'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postAuthor'];  ?> </span>
                        <?php endif ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="postTitle">News Title:</label>
                        <input type="text" name="postTitle" class="form-control">
                        <?php if (isset($errorMsg['postTitle'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postTitle'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="postDate">News Date:</label>
                        <input type="date" name="postDate" class="form-control">
                        <?php if (isset($errorMsg['postDate'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postDate'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="postCategory">News Category</label>
                        <select name="postCategory" class="form-control">
                            <option value=""> Select Category</option>
                            <?php foreach ($categorys as $category) : ?>
                                <option value="<?php echo $category['categoryID']  ?>"> <?php echo $category['categoryName']  ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php if (isset($errorMsg['postCategory'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postCategory'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="postSummary">News Summary:</label>
                        <textarea name="postSummary" class="form-control" rows="3"></textarea>
                        <?php if (isset($errorMsg['postSummary'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postSummary'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="postDescription">News Description:</label>
                        <textarea name="postDescription" class="form-control" rows="7"></textarea>
                        <?php if (isset($errorMsg['postDescription'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postDescription'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="postImage">News image</label>
                        <input type="file" name="postImage">
                        <?php if (isset($errorMsg['postImage'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postImage'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="postStatus">News Status</label>
                        <select name="postStatus" class="form-control">
                            <option value=""> Select Statue</option>
                            <option value="published">Published</option>
                            <option value="unpublished">Unpublished</option>
                        </select>
                        <?php if (isset($errorMsg['postStatus'])) : ?>
                            <span style="color: red;"> <?php echo $errorMsg['postStatus'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <input type="submit" name="postSubmit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>