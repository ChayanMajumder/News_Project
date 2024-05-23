<?php include "header.php"; ?>
<?php
require_once("../config/connect.php");
$selectSql = "SELECT categoryID, categoryName FROM news_categories";
$result = mysqli_query($conn, $selectSql);
$categoryData = mysqli_fetch_all($result, MYSQLI_ASSOC);

// print_r($categoryData);


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($categoryData as $data) :
                        ?>
                            <tr>
                                <td class='id'> <?php echo $i++   ?> </td>
                                <td> <?php echo $data['categoryName'];   ?> </td>
                                <td class='edit'><a href='update-category.php?categoryId=<?php echo $data['categoryID']   ?>'><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a href='delete-category.php'><i class='fa fa-trash-o'></i></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>