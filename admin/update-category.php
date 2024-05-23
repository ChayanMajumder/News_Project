<?php include "header.php"; ?>
<?php

$id = $_GET['categoryId'];
require_once("../config/connect.php");

$selectSql = "SELECT * FROM news_categories WHERE categoryID=$id";
$result = mysqli_query($conn, $selectSql);
$categoryData = mysqli_fetch_assoc($result);


$errorMag = [];

if (isset($_POST['categoryUpdate'])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Name = test_input($_POST['categoryName']);
    $description = test_input($_POST['categoryDescription']);

    if (empty($Name)) {
        $errorMag['name'] = "Please Enter a Category Name...!";
    }
    if (empty($description)) {
        $errorMag['description'] = "Please Enter a Category Description ...!";
    }

    if (count($errorMag) <= 0) {

        $date = date("Y-m-d H:i:s");

        $updateSql = "UPDATE news_categories SET categoryName = '$Name', categoryDescription = '$description', updatedAt = '$date' WHERE categoryID = '$id' ";
        $result = mysqli_query($conn, $updateSql);

        if($result) {
            echo "<script>alert('Category Update Successfully'); window.location.href = 'category.php'</script>";
        }
        else {
            echo "<script>alert('Category Not Update ')</script>";
        }
        // header("location: category.php");
    }
}

unset($_POST);


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading"> Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" name="categoryName" class="form-control" value="<?php echo $categoryData['categoryName'];  ?>" placeholder="">
                        <?php if (isset($errorMag['name'])) : ?>
                            <span style="color: red;"> <?php echo $errorMag['name'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="categoryDescription">Category Description:</label>
                        <textarea name="categoryDescription" id="" class="form-control"><?php echo $categoryData['categoryDescription'];  ?></textarea>
                        <?php if (isset($errorMag['description'])) : ?>
                            <span style="color: red;"> <?php echo $errorMag['description'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <input type="submit" name="categoryUpdate" class="btn btn-primary" value="Update" required />
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>