<?php include "header.php"; ?>

<?php
$errorMag = [];
$successMsg = null;
if (isset($_POST['categorySave'])) {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = test_input($_POST['categoryName']);
    $description = test_input($_POST['categoryDescription']);

    if (empty($name)) {
        $errorMag['name'] = "Please Enter a Category Name...!";
    }
    if (empty($description)) {
        $errorMag['description'] = "Please Enter a Category Description ...!";
    }

    if (count($errorMag) <= 0) {

        require_once("../config/connect.php");

        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO news_categories (categoryName, categoryDescription, createdAt) VALUES (?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $description, $date);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Category added Successfully')</script>";
        } else {
            echo "<script>alert('Category Not added')</script>";
        }
    }
}
unset($_POST);

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" name="categoryName" class="form-control" placeholder="Category Name">
                        <?php if (isset($errorMag['name'])) :  ?>
                            <span style="color:red"> <?php echo $errorMag['name'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group">        
                        <label for="categoryDescription">Category Description:</label>
                        <textarea name="categoryDescription" id="" class="form-control"></textarea>
                        <?php if (isset($errorMag['description'])) :  ?>
                            <span style="color:red"> <?php echo $errorMag['description'];  ?> </span>
                        <?php endif ?>
                    </div>
                    <input type="submit" name="categorySave" class="btn btn-primary" value="Save">
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>